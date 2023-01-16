<?php

namespace App\EventListener;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractErrorResponseEventListener
{
    protected function formatResponse(Response $response): void
    {
        $data = json_decode($response->getContent(), true);

        $response->setContent(
            json_encode([
                'message' => $data['message'],
                'type' => ResponseTypeEnum::error->name,
                'errors' => [],
            ])
        );
    }
}
