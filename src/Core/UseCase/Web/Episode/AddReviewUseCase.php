<?php

namespace App\Core\UseCase\Web\Episode;

use App\Core\Domain\Common\Authorization\GetAuthorizedUserIdInterface;
use App\Core\Domain\Web\Episode\AddEpisodeReviewInterface;
use App\Core\Domain\Web\Episode\CallWithTransactionInterface;
use App\Core\Domain\Web\Episode\MessageStatementFactory;
use App\Core\Domain\Web\Episode\RecalculateEpisodeSentimentInterface;

readonly class AddReviewUseCase
{
    public function __construct(
        private GetAuthorizedUserIdInterface $getAuthorizedUserId,
        private AddEpisodeReviewInterface $addEpisodeReview,
        private RecalculateEpisodeSentimentInterface $recalculateEpisodeSentiment,
        private MessageStatementFactory $messageStatementFactory,
        private CallWithTransactionInterface $callWithTransaction
    ) {
    }

    public function run(int $episodeId, string $message): void
    {
        $this->callWithTransaction->run(
            function () use ($episodeId, $message) {
                $sentiment = $this->messageStatementFactory->make($message);

                $this->addEpisodeReview->run(
                    $episodeId,
                    $this->getAuthorizedUserId->get(),
                    $message,
                    $sentiment
                );

                // Возможно стоит создать очередь и через cron пересчитывать общий балл, чтобы не задерживать юзера
                $this->recalculateEpisodeSentiment->run($episodeId);
            }
        );
    }
}
