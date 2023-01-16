<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(
    event: 'lexik_jwt_authentication.on_authentication_failure'
)]
class JWTOnAuthenticationFailureEventListener extends AbstractErrorResponseEventListener
{
    public function __invoke(AuthenticationFailureEvent $event): void
    {
        $this->formatResponse(
            $event->getResponse()
        );
    }
}
