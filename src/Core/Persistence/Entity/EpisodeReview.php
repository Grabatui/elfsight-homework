<?php

namespace App\Core\Persistence\Entity;

use App\Core\Persistence\Repository\EpisodeReviewRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodeReviewRepository::class)]
#[ORM\Table(name: '`episode_reviews`')]
class EpisodeReview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $episodeId;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $message;

    #[ORM\Column(type: 'float', nullable: false)]
    private float $sentimentRank;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    public function __construct(
        int $episodeId,
        User $user,
        string $message,
        float $sentimentRank,
        DateTimeInterface $createdAt
    ) {
        $this->setEpisodeId($episodeId);
        $this->setUser($user);
        $this->setMessage($message);
        $this->setSentimentRank($sentimentRank);
        $this->setCreatedAt($createdAt);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEpisodeId(): int
    {
        return $this->episodeId;
    }

    public function setEpisodeId(int $episodeId): void
    {
        $this->episodeId = $episodeId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getSentimentRank(): float
    {
        return $this->sentimentRank;
    }

    public function setSentimentRank(float $sentimentRank): void
    {
        $this->sentimentRank = $sentimentRank;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
