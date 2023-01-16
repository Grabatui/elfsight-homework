<?php

namespace App\EventListener;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => 'onKernelResponse'];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (in_array($response->getStatusCode(), [200, 201])) {
            return;
        }

        $data = json_decode($response->getContent(), true);

        if ($this->isResponseAlreadyFormatted($data)) {
            return;
        }

        $response->setContent(
            json_encode([
                'message' => $data['message'],
                'type' => ResponseTypeEnum::error->value,
                'errors' => [],
            ])
        );
    }

    private function isResponseAlreadyFormatted(array $data): bool
    {
        return (
            array_key_exists('message', $data)
            && array_key_exists('type', $data)
            && ResponseTypeEnum::tryFrom($data['type'])
            && array_key_exists('errors', $data)
        );
    }
}
