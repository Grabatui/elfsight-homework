<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\AddEpisodeReviewInterface;
use App\Core\Persistence\Model\Web\Episode\EpisodeReviewModel;
use App\Core\Persistence\Repository\EpisodeReviewRepository;
use App\Core\Persistence\Repository\UserRepository;
use RuntimeException;

readonly class AddEpisodeReviewAction implements AddEpisodeReviewInterface
{
    public function __construct(
        private EpisodeReviewRepository $episodeReviewRepository,
        private EpisodeReviewModel $episodeReviewModel,
        private UserRepository $userRepository
    ) {
    }

    public function run(int $episodeId, int $userId, string $message, float $sentiment): void
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new RuntimeException('User not found');
        }

        $this->episodeReviewRepository->save(
            $this->episodeReviewModel->makeNewForRepository($user, $episodeId, $message, $sentiment),
            true
        );
    }
}
