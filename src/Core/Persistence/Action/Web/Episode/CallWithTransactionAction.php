<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\CallWithTransactionInterface;
use App\Core\Persistence\Repository\EpisodeReviewRepository;
use Throwable;

readonly class CallWithTransactionAction implements CallWithTransactionInterface
{
    public function __construct(
        private EpisodeReviewRepository $episodeReviewRepository
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(callable $callback): void
    {
        $this->episodeReviewRepository->startTransaction();

        try {
            $callback();

            $this->episodeReviewRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->episodeReviewRepository->rollbackTransaction();

            throw $exception;
        }
    }
}
