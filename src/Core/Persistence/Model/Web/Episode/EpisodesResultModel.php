<?php

namespace App\Core\Persistence\Model\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Domain\Web\Episode\Entity\EpisodesResult as DomainEpisodesResult;
use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodeEntity;
use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodesResult as RepositoryEpisodesResult;

class EpisodesResultModel
{
    public function fromRepositoryToDomain(RepositoryEpisodesResult $repositoryResult): DomainEpisodesResult
    {
        return new DomainEpisodesResult(
            array_map(
                static fn (EpisodeEntity $episodeEntity): Episode => new Episode(
                    $episodeEntity->getId(),
                    $episodeEntity->getName(),
                    $episodeEntity->getReleaseDatetime()
                ),
                $repositoryResult->getEpisodes()
            ),
            $repositoryResult->isNextExists(),
            $repositoryResult->isPrevExists()
        );
    }
}
