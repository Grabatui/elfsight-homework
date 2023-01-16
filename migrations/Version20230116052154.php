<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116052154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "episode_sentiment_ranks" (episode_id INT NOT NULL, sentiment_rank DOUBLE PRECISION NOT NULL, PRIMARY KEY(episode_id))');
        $this->addSql('ALTER TABLE episode_reviews RENAME COLUMN sentiment TO sentiment_rank');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "episode_sentiment_ranks"');
        $this->addSql('ALTER TABLE "episode_reviews" RENAME COLUMN sentiment_rank TO sentiment');
    }
}
