<?php

namespace App\Core\Domain\Common\User;

interface IsUserExistsByUsernameInterface
{
    public function is(string $username): bool;
}
