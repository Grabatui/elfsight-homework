<?php

namespace App\Security;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\JsonLoginAuthenticator;

class CustomJsonLoginAuthenticator extends JsonLoginAuthenticator
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(
            [
                'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
                'type' => ResponseTypeEnum::error->name,
                'errors' => [],
            ],
            JsonResponse::HTTP_UNAUTHORIZED
        );
    }
}
