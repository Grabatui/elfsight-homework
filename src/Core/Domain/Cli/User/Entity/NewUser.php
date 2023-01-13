<?php

namespace App\Core\Domain\Cli\User\Entity;

use App\Core\Domain\Cli\User\Entity\Enum\UserRoleEnum;

readonly class NewUser
{
    public function __construct(
        private string $username,
        private string $hashedPassword,
        private UserRoleEnum $role
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getRole(): UserRoleEnum
    {
        return $this->role;
    }
}
