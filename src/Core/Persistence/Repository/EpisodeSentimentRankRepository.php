<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\EpisodeSentimentRank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EpisodeSentimentRank>
 *
 * @method EpisodeSentimentRank|null find($id, $lockMode = null, $lockVersion = null)
 * @method EpisodeSentimentRank|null findOneBy(array $criteria, array $orderBy = null)
 * @method EpisodeSentimentRank[]    findAll()
 * @method EpisodeSentimentRank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpisodeSentimentRankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EpisodeSentimentRank::class);
    }

    public function save(EpisodeSentimentRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
