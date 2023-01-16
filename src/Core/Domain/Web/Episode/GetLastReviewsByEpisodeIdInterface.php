<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\EpisodeReview;

interface GetLastReviewsByEpisodeIdInterface
{
    /**
     * @param int $episodeId
     * @param int $count
     * @return EpisodeReview[]
     */
    public function get(int $episodeId, int $count): array;
}
