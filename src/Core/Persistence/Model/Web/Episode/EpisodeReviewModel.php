<?php

namespace App\Core\Persistence\Model\Web\Episode;

use App\Core\Persistence\Entity\EpisodeReview;
use App\Core\Persistence\Entity\User;
use DateTimeImmutable;

class EpisodeReviewModel
{
    public function makeNewForRepository(User $user, int $episodeId, string $message, float $sentiment): EpisodeReview
    {
        return new EpisodeReview(
            $episodeId,
            $user,
            $message,
            $sentiment,
            new DateTimeImmutable()
        );
    }
}
