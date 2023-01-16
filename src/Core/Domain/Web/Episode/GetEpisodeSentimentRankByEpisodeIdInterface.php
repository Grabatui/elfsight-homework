<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;

interface GetEpisodeSentimentRankByEpisodeIdInterface
{
    /**
     * @throws OutputException
     */
    public function get(int $episodeId): float;
}
