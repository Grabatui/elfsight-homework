<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\EpisodeWithSentimentAndReviews;

readonly class EpisodeWithSentimentAndReviewsFactory
{
    public function __construct(
        private GetOneEpisodeByIdInterface $getOneEpisodeById,
        private GetEpisodeSentimentRankByEpisodeIdInterface $getEpisodeSentimentRankByEpisodeId,
        private GetLastReviewsByEpisodeIdInterface $getLastReviewsByEpisodeId
    ) {
    }

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
