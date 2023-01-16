<?php

namespace App\Core\Persistence\Model\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Domain\Web\Episode\Entity\EpisodesResult as DomainEpisodesResult;
use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodeEntity;
use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodesResult as RepositoryEpisodesResult;

readonly class EpisodesResultModel
{
    public function __construct(
        private EpisodeModel $episodeModel
    ) {
    }

    public function fromRepositoryToDomain(RepositoryEpisodesResult $repositoryResult): DomainEpisodesResult
    {
        return new DomainEpisodesResult(
            array_map(
                fn (EpisodeEntity $episodeEntity): Episode => $this->episodeModel->fromRepositoryToDomain(
                    $episodeEntity
                ),
                $repositoryResult->getEpisodes()
            ),
            $repositoryResult->isNextExists(),
            $repositoryResult->isPrevExists()
        );
    }
}
