<?php

namespace App\Core\Domain\Common\Authorization;

interface GetAuthorizedUserIdInterface
{
    public function get(): int;
}
