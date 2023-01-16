<?php

namespace App\Core\Presentation\Request\v1\Episode;

use App\Core\Presentation\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;

class AddReviewRequest extends AbstractRequest
{
    public function getMessage(): string
    {
        return $this->request->request->get('message');
    }

    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules(
            [
                'attributes' => [
                    'id' => 'integer|required',
                ],
                'request' => [
                    'message' => 'string|required',
                ],
            ],
            true
        );
    }
}
