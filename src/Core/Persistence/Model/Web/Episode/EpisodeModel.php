<?php

namespace App\Core\Persistence\Model\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodeEntity;

class EpisodeModel
{
    public function fromRepositoryToDomain(EpisodeEntity $episodeEntity): Episode
    {
        return new Episode(
            $episodeEntity->getId(),
            $episodeEntity->getName(),
            $episodeEntity->getReleaseDatetime()
        );
    }
}
