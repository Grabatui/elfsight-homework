<?php

namespace App\Core\Presentation\Request\v1\Episode;

use App\Core\Presentation\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;

class GetAllRequest extends AbstractRequest
{
    public function getPage(): ?int
    {
        return $this->request->query->get('page');
    }

    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'query' => [
                'page' => 'integer',
            ],
        ]);
    }
}
