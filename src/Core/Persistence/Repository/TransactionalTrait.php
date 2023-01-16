<?php

namespace App\Core\Persistence\Repository;

trait TransactionalTrait
{
    public function startTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commitTransaction(): void
    {
        $this->getEntityManager()->commit();
    }
    public function rollbackTransaction(): void
    {
        $this->getEntityManager()->rollback();
    }
}
