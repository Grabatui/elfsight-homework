<?php

namespace App\Core\Presentation\Formatter\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Domain\Web\Episode\Entity\EpisodeReview;
use App\Core\Domain\Web\Episode\Entity\EpisodeWithSentimentAndReviews;

class EpisodeFormatter
{
    private const RELEASE_DATE_FORMAT = 'Y-m-d';

    public function format(Episode $episode): array
    {
        return [
            'id' => $episode->getId(),
            'name' => $episode->getName(),
            'release_date' => $episode->getReleaseDatetime()->format(static::RELEASE_DATE_FORMAT),
        ];
    }

    public function formatWithSentimentAndReviews(EpisodeWithSentimentAndReviews $episode): array
    {
        return [
            'id' => $episode->getId(),
            'name' => $episode->getName(),
            'release_date' => $episode->getReleaseDatetime()->format(static::RELEASE_DATE_FORMAT),
            'sentiment_rank' => $episode->getSentimentRank(),
            'reviews' => array_map(
                static fn (EpisodeReview $episodeReview): array => [
                    'message' => $episodeReview->getMessage(),
                    'sentiment_rank' => $episodeReview->getSentimentRank(),
                ],
                $episode->getReviews()
            ),
        ];
    }
}
