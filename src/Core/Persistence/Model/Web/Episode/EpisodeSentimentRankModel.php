<?php

namespace App\Core\Persistence\Model\Web\Episode;

use App\Core\Persistence\Entity\EpisodeSentimentRank;
use DateTimeImmutable;
use DateTimeInterface;

class EpisodeSentimentRankModel
{
    public function makeNewForRepository(int $episodeId, float $sentimentRank): EpisodeSentimentRank
    {
        $createdAndUpdatedAt = new DateTimeImmutable();

        return new EpisodeSentimentRank(
            $episodeId,
            $sentimentRank,
            $createdAndUpdatedAt,
            $createdAndUpdatedAt
        );
    }

    public function makeUpdatedForRepository(
        EpisodeSentimentRank $entity,
        float $sentimentRank
    ): void {
        $entity->setSentimentRank($sentimentRank);
        $entity->setUpdatedAt(new DateTimeImmutable());
    }
}
