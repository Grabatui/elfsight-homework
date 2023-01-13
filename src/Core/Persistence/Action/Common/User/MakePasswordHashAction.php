<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\User\MakePasswordHashInterface;
use App\Core\Persistence\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class MakePasswordHashAction implements MakePasswordHashInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function run(string $password): string
    {
        return $this->userPasswordHasher->hashPassword(new User(), $password);
    }
}
