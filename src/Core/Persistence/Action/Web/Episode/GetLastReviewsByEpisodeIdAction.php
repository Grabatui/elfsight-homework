<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\Entity\EpisodeReview as DomainEpisodeReview;
use App\Core\Domain\Web\Episode\GetLastReviewsByEpisodeIdInterface;
use App\Core\Persistence\Entity\EpisodeReview;
use App\Core\Persistence\Model\Web\Episode\EpisodeReviewModel;
use App\Core\Persistence\Repository\EpisodeReviewRepository;

readonly class GetLastReviewsByEpisodeIdAction implements GetLastReviewsByEpisodeIdInterface
{
    public function __construct(
        private EpisodeReviewRepository $episodeReviewRepository,
        private EpisodeReviewModel $episodeReviewModel
    ) {
    }

    public function get(int $episodeId, int $count): array
    {
        $reviews = $this->episodeReviewRepository->getTopReviewsByEpisodeId($episodeId, $count);

        return array_map(
            fn (EpisodeReview $episodeReview): DomainEpisodeReview => $this
                ->episodeReviewModel
                ->fromRepositoryToDomain($episodeReview),
            $reviews
        );
    }
}
