<?php

namespace App\Core\Domain\Web\Episode\Entity;

use DateTimeInterface;

readonly class EpisodeWithSentimentAndReviews
{
    /**
     * @param int $id
     * @param string $name
     * @param DateTimeInterface $releaseDatetime
     * @param float $sentimentRank
     * @param EpisodeReview[] $reviews
     */
    public function __construct(
        private int $id,
        private string $name,
        private DateTimeInterface $releaseDatetime,
        private float $sentimentRank,
        private array $reviews
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseDatetime(): DateTimeInterface
    {
        return $this->releaseDatetime;
    }

    public function getSentimentRank(): float
    {
        return $this->sentimentRank;
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }
}
