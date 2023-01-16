<?php

namespace App\Core\Domain\Web\Episode;

interface GetRawSentimentForMessageInterface
{
    public function get(string $message): float;
}
