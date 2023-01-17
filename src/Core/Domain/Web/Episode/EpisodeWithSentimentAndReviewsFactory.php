<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Domain\Web\Episode\Entity\EpisodeWithSentimentAndReviews;

readonly class EpisodeWithSentimentAndReviewsFactory
{
    public function __construct(
        private GetOneEpisodeByIdInterface $getOneEpisodeById,
        private GetEpisodeSentimentRankByEpisodeIdInterface $getEpisodeSentimentRankByEpisodeId,
        private GetLastReviewsByEpisodeIdInterface $getLastReviewsByEpisodeId
    ) {
    }

    /**
     * @throws OutputException
     */
    public function make(
        int $episodeId,
        int $reviewsCount
    ): EpisodeWithSentimentAndReviews {
        $episode = $this->getOneEpisodeById->get($episodeId);

        return new EpisodeWithSentimentAndReviews(
            $episode->getId(),
            $episode->getName(),
            $episode->getReleaseDatetime(),
            $this->getEpisodeSentimentRankByEpisodeId->get($episodeId),
            $this->getLastReviewsByEpisodeId->get($episodeId, $reviewsCount)
        );
    }
}
