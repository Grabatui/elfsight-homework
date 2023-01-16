<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Domain\Web\Episode\GetEpisodeSentimentRankByEpisodeIdInterface;
use App\Core\Persistence\Repository\EpisodeSentimentRankRepository;

readonly class GetEpisodeSentimentRankByEpisodeIdAction implements GetEpisodeSentimentRankByEpisodeIdInterface
{
    public function __construct(
        private EpisodeSentimentRankRepository $episodeSentimentRankRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function get(int $episodeId): float
    {
        $entity = $this->episodeSentimentRankRepository->find($episodeId);

        if (!$entity) {
            throw OutputException::makeAsNotFound('Episode sentiment rank not found');
        }

        return $entity->getSentimentRank();
    }
}
