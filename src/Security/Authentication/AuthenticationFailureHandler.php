<?php

namespace App\Security\Authentication;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler as BaseAuthenticationFailureHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationFailureHandler extends BaseAuthenticationFailureHandler
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $response = parent::onAuthenticationFailure($request, $exception);

        $data = json_decode($response->getContent(), true);

        return new JsonResponse(
            [
                'message' => $data['message'],
                'type' => ResponseTypeEnum::error->value,
                'errors' => [],
            ],
            $data['code']
        );
    }
}
