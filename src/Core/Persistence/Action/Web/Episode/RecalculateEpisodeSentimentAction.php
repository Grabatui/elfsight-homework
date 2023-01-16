<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\RecalculateEpisodeSentimentInterface;
use App\Core\Persistence\Model\Web\Episode\EpisodeSentimentRankModel;
use App\Core\Persistence\Repository\EpisodeReviewRepository;
use App\Core\Persistence\Repository\EpisodeSentimentRankRepository;
use Doctrine\ORM\NonUniqueResultException;

readonly class RecalculateEpisodeSentimentAction implements RecalculateEpisodeSentimentInterface
{
    public function __construct(
        private EpisodeReviewRepository $episodeReviewRepository,
        private EpisodeSentimentRankRepository $episodeSentimentRankRepository,
        private EpisodeSentimentRankModel $episodeSentimentRankModel
    ) {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function run(int $episodeId): void
    {
        $sentimentRank = $this->episodeReviewRepository->getAverageSentimentRankByEpisodeId($episodeId);

        $entity = $this->episodeSentimentRankRepository->find($episodeId);

        if ($entity) {
            $this->episodeSentimentRankModel->makeUpdatedForRepository(
                $entity,
                $sentimentRank
            );
        } else {
            $entity = $this->episodeSentimentRankModel->makeNewForRepository(
                $episodeId,
                $sentimentRank
            );
        }

        $this->episodeSentimentRankRepository->save($entity, true);
    }
}
