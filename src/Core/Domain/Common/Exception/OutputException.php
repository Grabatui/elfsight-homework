<?php

namespace App\Core\Domain\Common\Exception;

use App\Core\Domain\Common\Exception\Entity\TypeEnum;
use Exception;

class OutputException extends Exception
{
    public function __construct(
        private readonly TypeEnum $type,
        string $message
    ) {
        parent::__construct($message);
    }

    public static function makeAsNotFound(string $message): self
    {
        return new self(TypeEnum::not_found, $message);
    }

    public function getType(): TypeEnum
    {
        return $this->type;
    }
}
