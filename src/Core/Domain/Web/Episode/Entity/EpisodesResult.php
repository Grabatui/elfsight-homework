<?php

namespace App\Core\Domain\Web\Episode\Entity;

readonly class EpisodesResult
{
    /**
     * @param Episode[] $episodes
     * @param bool $isNextExists
     * @param bool $isPrevExists
     */
    public function __construct(
        private array $episodes,
        private bool $isNextExists,
        private bool $isPrevExists
    ) {
    }

    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    public function isNextExists(): bool
    {
        return $this->isNextExists;
    }

    public function isPrevExists(): bool
    {
        return $this->isPrevExists;
    }
}
