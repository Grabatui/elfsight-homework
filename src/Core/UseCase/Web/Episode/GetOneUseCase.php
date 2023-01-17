<?php

namespace App\Core\UseCase\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Domain\Web\Episode\Entity\EpisodeWithSentimentAndReviews;
use App\Core\Domain\Web\Episode\EpisodeWithSentimentAndReviewsFactory;

readonly class GetOneUseCase
{
    private const REVIEWS_COUNT = 3;

    public function __construct(
        private EpisodeWithSentimentAndReviewsFactory $episodeWithSentimentAndReviewsFactory
    ) {
    }

    /**
     * @throws OutputException
     */
    public function get(int $episodeId): EpisodeWithSentimentAndReviews
    {
        return $this->episodeWithSentimentAndReviewsFactory->make($episodeId, static::REVIEWS_COUNT);
    }
}
