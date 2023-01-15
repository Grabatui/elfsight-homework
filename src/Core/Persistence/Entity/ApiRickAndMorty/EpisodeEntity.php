<?php

namespace App\Core\Persistence\Entity\ApiRickAndMorty;

use DateTimeInterface;

readonly class EpisodeEntity
{
    public function __construct(
        private int $id,
        private string $name,
        private DateTimeInterface $releaseDatetime
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
}
