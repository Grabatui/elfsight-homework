<?php

namespace App\Core\Presentation\Provider\User;

use App\Core\Domain\Common\User\IsUserExistsByUsernameInterface;

readonly class UserProvider
{
    public function __construct(
        private IsUserExistsByUsernameInterface $isUserExistsByUsername
    ) {
    }

    public function isUserExistsByUsername(string $username): bool
    {
        return $this->isUserExistsByUsername->is($username);
    }
}
