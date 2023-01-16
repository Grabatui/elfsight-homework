<?php

namespace App\Core\Domain\Web\Episode;

interface GetEpisodeSentimentRankByEpisodeIdInterface
{
    public function get(int $episodeId): float;
}
