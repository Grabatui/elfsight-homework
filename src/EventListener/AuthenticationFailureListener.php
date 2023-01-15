<?php

namespace App\EventListener;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(
    event: 'lexik_jwt_authentication.on_authentication_failure'
)]
class AuthenticationFailureListener
{
    public function __invoke(AuthenticationFailureEvent $event): void
    {
        $response = $event->getResponse();

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
