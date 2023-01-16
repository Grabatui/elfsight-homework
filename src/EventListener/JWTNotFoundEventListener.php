<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(
    event: 'lexik_jwt_authentication.on_jwt_not_found'
)]
class JWTNotFoundEventListener extends AbstractErrorResponseEventListener
{
    public function __invoke(JWTNotFoundEvent $event): void
    {
        $this->formatResponse(
            $event->getResponse()
        );
    }
}
