<?php

namespace App\Core\Domain\Web\Episode;

interface CallWithTransactionInterface
{
    public function run(callable $callback): void;
}
