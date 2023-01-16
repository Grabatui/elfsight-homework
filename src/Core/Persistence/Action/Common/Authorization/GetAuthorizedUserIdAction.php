<?php

namespace App\Core\Persistence\Action\Common\Authorization;

use App\Core\Domain\Common\Authorization\GetAuthorizedUserIdInterface;

class GetAuthorizedUserIdAction implements GetAuthorizedUserIdInterface
{
    public function get(): int
    {
        return 5; // TODO
    }
}
