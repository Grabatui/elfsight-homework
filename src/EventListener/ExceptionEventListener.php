<?php

namespace App\EventListener;

use App\Core\Domain\Common\Exception\Entity\TypeEnum;
use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use App\Core\Presentation\Exception\Request\ConstraintViolationsException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

#[AsEventListener(
    event: 'kernel.exception'
)]
class ExceptionEventListener
{
    private const CONTENT_TYPE_HEADER_KEY = 'Content-Type';
    private const APPLICATION_JSON_HEADER_VALUE = 'application/json';

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = $this->isJson($event)
            ? new JsonResponse($this->makeContent($exception))
            : new Response($exception->getMessage());

        $exceptionStatusCode = $this->makeStatusCode($exception);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode(
                $exceptionStatusCode ?: $exception->getStatusCode()
            );
        } else {
            $response->setStatusCode(
                $exceptionStatusCode ?: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $event->setResponse($response);
    }

    private function isJson(ExceptionEvent $event): bool
    {
        return $event->getRequest()->headers->get(self::CONTENT_TYPE_HEADER_KEY) === self::APPLICATION_JSON_HEADER_VALUE;
    }

    private function makeContent(Throwable $exception): array
    {
        $result = [
            'message' => $exception->getMessage(),
            'type' => ResponseTypeEnum::error->name,
            'errors' => [],
        ];

        if ($exception instanceof ConstraintViolationsException) {
            foreach ($exception->getConstraintViolationList() as $constraintViolation) {
                $result['errors'][] = [
                    'path' => $this->clearErrorPath(
                        $constraintViolation->getPropertyPath()
                    ),
                    'code' => $constraintViolation->getCode(),
                    'message' => $constraintViolation->getMessage(),
                ];
            }
        }

        return $result;
    }

    private function clearErrorPath(string $rawPath): string
    {
        return trim(
            str_replace(
                ['[request]', '[query]', ']['],
                ['', '', '.'],
                $rawPath
            ),
            '[]'
        );
    }

    private function makeStatusCode(Throwable $exception): ?int
    {
        if ($exception instanceof OutputException) {
            return match ($exception->getType()) {
                TypeEnum::not_found => Response::HTTP_NOT_FOUND
            };
        }

        return null;
    }
}
