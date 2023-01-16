<?php

namespace App\Core\Domain\Web\Episode\Entity;

readonly class EpisodeReview
{
    public function __construct(
        private string $message,
        private float $sentimentRank
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSentimentRank(): float
    {
        return $this->sentimentRank;
    }
}
