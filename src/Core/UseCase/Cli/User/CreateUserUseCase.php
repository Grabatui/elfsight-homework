<?php

namespace App\Core\UseCase\Cli\User;

use App\Core\Domain\Cli\User\CreateUserInterface;
use App\Core\Domain\Cli\User\Entity\Enum\UserRoleEnum;
use App\Core\Domain\Cli\User\Entity\NewUser;
use App\Core\Domain\Common\User\MakePasswordHashInterface;

readonly class CreateUserUseCase
{
    public function __construct(
        private MakePasswordHashInterface $makePasswordHash,
        private CreateUserInterface $createUser
    ) {
    }

    public function run(string $username, string $password, bool $isAdmin): void
    {
        $this->createUser->run(
            new NewUser(
                $username,
                $this->makePasswordHash->run($password),
                $isAdmin ? UserRoleEnum::ROLE_ADMIN : UserRoleEnum::ROLE_USER
            )
        );
    }
}
