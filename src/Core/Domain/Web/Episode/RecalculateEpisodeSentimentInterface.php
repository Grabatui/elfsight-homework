<?php

namespace App\Core\Domain\Web\Episode;

interface RecalculateEpisodeSentimentInterface
{
    public function run(int $episodeId): void;
}
