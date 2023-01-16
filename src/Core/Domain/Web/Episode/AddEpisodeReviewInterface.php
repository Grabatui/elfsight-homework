<?php

namespace App\Core\Domain\Web\Episode;

interface AddEpisodeReviewInterface
{
    public function run(int $episodeId, int $userId, string $message, float $sentiment): void;
}
