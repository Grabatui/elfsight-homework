<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;

interface GetOneEpisodeByIdInterface
{
    public function get(int $id): Episode;
}
