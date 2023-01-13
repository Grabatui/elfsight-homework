<?php

namespace App\Core\Domain\Cli\User;

use App\Core\Domain\Cli\User\Entity\NewUser;

interface CreateUserInterface
{
    public function run(NewUser $user): void;
}
