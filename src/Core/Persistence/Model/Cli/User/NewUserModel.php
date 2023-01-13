<?php

namespace App\Core\Persistence\Model\Cli\User;

use App\Core\Domain\Cli\User\Entity\NewUser;
use App\Core\Persistence\Entity\User;

class NewUserModel
{
    public function fromDomainToDatabase(NewUser $user): User
    {
        $databaseUser = new User();
        $databaseUser->setUsername($user->getUsername());
        $databaseUser->setPassword($user->getHashedPassword());
        $databaseUser->setRoles([$user->getRole()->name]);

        return $databaseUser;
    }
}
