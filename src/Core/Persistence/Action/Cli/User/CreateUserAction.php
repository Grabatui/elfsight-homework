<?php

namespace App\Core\Persistence\Action\Cli\User;

use App\Core\Domain\Cli\User\CreateUserInterface;
use App\Core\Domain\Cli\User\Entity\NewUser;
use App\Core\Persistence\Model\Cli\User\NewUserModel;
use App\Core\Persistence\Repository\UserRepository;

readonly class CreateUserAction implements CreateUserInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private NewUserModel $newUserModel
    ) {
    }

    public function run(NewUser $user): void
    {
        $this->userRepository->save(
            $this->newUserModel->fromDomainToDatabase($user),
            true
        );
    }
}
