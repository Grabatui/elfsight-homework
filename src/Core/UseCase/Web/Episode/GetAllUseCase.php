<?php

namespace App\Core\UseCase\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\EpisodesResult;
use App\Core\Domain\Web\Episode\GetAllEpisodesInterface;

readonly class GetAllUseCase
{
    public function __construct(
        private GetAllEpisodesInterface $getAllEpisodes
    ) {
    }

    public function get(?int $page = null): EpisodesResult
    {
        return $this->getAllEpisodes->get($page);
    }
}
