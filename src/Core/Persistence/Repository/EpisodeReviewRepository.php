<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\EpisodeReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EpisodeReview>
 *
 * @method EpisodeReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method EpisodeReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method EpisodeReview[]    findAll()
 * @method EpisodeReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpisodeReviewRepository extends ServiceEntityRepository
{
    use TransactionalTrait;

    private const MAX_SELECTED_REVIEWS_COUNT = 100;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EpisodeReview::class);
    }

    public function save(EpisodeReview $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getAverageSentimentRankByEpisodeId(int $episodeId): float
    {
        $row = $this->createQueryBuilder('episode_review')
            ->select(['AVG(episode_review.sentimentRank)'])
            ->where('episode_review.episodeId = :episodeId')
            ->setParameters(compact('episodeId'))
            ->getQuery()
            ->getOneOrNullResult();

        return !empty($row) ? (float) reset($row) : 0.0;
    }

    public function getTopReviewsByEpisodeId(int $episodeId, int $count): array
    {
        $count = min($count, static::MAX_SELECTED_REVIEWS_COUNT);

        return $this->findBy(
            criteria: compact('episodeId'),
            orderBy: [
                'sentimentRank' => 'DESC',
                'createdAt' => 'DESC',
            ],
            limit: $count
        );
    }
}
