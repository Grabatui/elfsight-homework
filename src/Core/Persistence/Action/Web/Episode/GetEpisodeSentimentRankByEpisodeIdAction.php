<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\GetEpisodeSentimentRankByEpisodeIdInterface;
use App\Core\Persistence\Repository\EpisodeSentimentRankRepository;
use RuntimeException;

readonly class GetEpisodeSentimentRankByEpisodeIdAction implements GetEpisodeSentimentRankByEpisodeIdInterface
{
    public function __construct(
        private EpisodeSentimentRankRepository $episodeSentimentRankRepository
    ) {
    }

    public function get(int $episodeId): float
    {
        $entity = $this->episodeSentimentRankRepository->find($episodeId);

        if (!$entity) {
            throw new RuntimeException('Episode sentiment rank not found');
        }

        return $entity->getSentimentRank();
    }
}
