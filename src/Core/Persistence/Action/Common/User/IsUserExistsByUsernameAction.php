<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\User\IsUserExistsByUsernameInterface;
use App\Core\Persistence\Repository\UserRepository;

readonly class IsUserExistsByUsernameAction implements IsUserExistsByUsernameInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function is(string $username): bool
    {
        return (bool)$this->userRepository->findOneBy(compact('username'));
    }
}
