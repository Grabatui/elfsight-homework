<?php

namespace App\Core\Persistence\Action\Common\Authorization;

use App\Core\Domain\Common\Authorization\GetAuthorizedUserIdInterface;
use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Persistence\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

readonly class GetAuthorizedUserIdAction implements GetAuthorizedUserIdInterface
{
    public function __construct(
        private Security $security
    ) {
    }

    /**
     * @inheritDoc
     */
    public function get(): int
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (!$user) {
            throw OutputException::makeAsNotFound('User not found');
        }

        return $user->getId();
    }
}
