<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\EpisodesResult;

interface GetAllEpisodesInterface
{
    public function get(?int $page = null): EpisodesResult;
}
