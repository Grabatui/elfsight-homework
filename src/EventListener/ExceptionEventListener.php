<?php

namespace App\EventListener;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionEventListener
{
    private const CONTENT_TYPE_HEADER_KEY = 'Content-Type';
    private const APPLICATION_JSON_HEADER_VALUE = 'application/json';

    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = $this->isJson($event)
            ? new JsonResponse($this->makeContent($exception))
            : new Response($exception->getMessage());

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }

    private function isJson(ExceptionEvent $event): bool
    {
        return self::APPLICATION_JSON_HEADER_VALUE === $event->getRequest()->headers->get(self::CONTENT_TYPE_HEADER_KEY);
    }

    private function makeContent(\Throwable $exception): array
    {
        $result = [
            'message' => $exception->getMessage(),
            'type' => ResponseTypeEnum::error->name,
            'errors' => [],
        ];

        // TODO
//        if ($exception instanceof ConstraintViolationsException) {
//            foreach ($exception->getConstraintViolationList() as $constraintViolation) {
//                $result['errors'][] = [
//                    'path' => $this->clearErrorPath(
//                        $constraintViolation->getPropertyPath()
//                    ),
//                    'code' => $constraintViolation->getCode(),
//                    'message' => $constraintViolation->getMessage(),
//                ];
//            }
//        }

        return $result;
    }

    private function clearErrorPath(string $rawPath): string
    {
        return trim(
            str_replace(
                ['[request]', ']['],
                ['', '.'],
                $rawPath
            ),
            '[]'
        );
    }

    private function isExceptionCanBeOutput(\Throwable $exception): bool
    {
        foreach (static::OUTPUT_EXCEPTIONS as $outputExceptionClass) {
            if ($exception instanceof $outputExceptionClass) {
                return true;
            }
        }

        return false;
    }
}
