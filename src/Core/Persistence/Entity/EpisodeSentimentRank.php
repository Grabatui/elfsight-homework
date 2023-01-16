<?php

namespace App\Core\Persistence\Entity;

use App\Core\Persistence\Repository\EpisodeSentimentRankRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodeSentimentRankRepository::class)]
#[ORM\Table(name: '`episode_sentiment_ranks`')]
class EpisodeSentimentRank
{
    #[ORM\Id]
    #[ORM\Column]
    private int $episodeId;

    #[ORM\Column(type: 'float', nullable: false)]
    private float $sentimentRank;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTimeInterface $updatedAt;

    public function __construct(
        int $episodeId,
        float $sentimentRank,
        DateTimeInterface $createdAt,
        DateTimeInterface $updatedAt
    ) {
        $this->setEpisodeId($episodeId);
        $this->setSentimentRank($sentimentRank);
        $this->setCreatedAt($createdAt);
        $this->setUpdatedAt($updatedAt);
    }

    public function getEpisodeId(): int
    {
        return $this->episodeId;
    }

    public function setEpisodeId(int $episodeId): void
    {
        $this->episodeId = $episodeId;
    }

    public function getSentimentRank(): float
    {
        return $this->sentimentRank;
    }

    public function setSentimentRank(float $sentimentRank): void
    {
        $this->sentimentRank = $sentimentRank;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
