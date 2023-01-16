<?php

namespace App\Core\Domain\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Domain\Web\Episode\Entity\Episode;

interface GetOneEpisodeByIdInterface
{
    /**
     * @throws OutputException
     */
    public function get(int $id): Episode;
}
