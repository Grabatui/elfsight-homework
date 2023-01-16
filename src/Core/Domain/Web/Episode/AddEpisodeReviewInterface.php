<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;

interface AddEpisodeReviewInterface
{
    /**
     * @throws OutputException
     */
    public function run(int $episodeId, int $userId, string $message, float $sentiment): void;
}
