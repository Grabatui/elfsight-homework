<?php

namespace App\Core\Domain\Common\Authorization;

use App\Core\Domain\Common\Exception\OutputException;

interface GetAuthorizedUserIdInterface
{
    /**
     * @throws OutputException
     */
    public function get(): int;
}
