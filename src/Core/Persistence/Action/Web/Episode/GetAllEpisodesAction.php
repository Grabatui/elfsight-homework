<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\EpisodesResult;
use App\Core\Domain\Web\Episode\GetAllEpisodesInterface;
use App\Core\Persistence\Model\Web\Episode\EpisodesResultModel;
use App\Core\Persistence\Repository\ApiRickAndMorty\RickAndMortyApiRepository;

readonly class GetAllEpisodesAction implements GetAllEpisodesInterface
{
    public function __construct(
        private RickAndMortyApiRepository $andMortyApiRepository,
        private EpisodesResultModel $episodesResultModel
    ) {
    }

    public function get(?int $page = null): EpisodesResult
    {
        return $this->episodesResultModel->fromRepositoryToDomain(
            $this->andMortyApiRepository->getAllEpisodes($page)
        );
    }
}
