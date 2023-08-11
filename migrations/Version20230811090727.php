<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230811090727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_favorite_teams (user_profile_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(user_profile_id, team_id))');
        $this->addSql('CREATE INDEX IDX_4BCFD6256B9DD454 ON user_favorite_teams (user_profile_id)');
        $this->addSql('CREATE INDEX IDX_4BCFD625296CD8AE ON user_favorite_teams (team_id)');
        $this->addSql('ALTER TABLE user_favorite_teams ADD CONSTRAINT FK_4BCFD6256B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite_teams ADD CONSTRAINT FK_4BCFD625296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_data DROP CONSTRAINT fk_d772bfaa743876c0');
        $this->addSql('DROP INDEX idx_d772bfaa743876c0');
        $this->addSql('ALTER TABLE user_data DROP favorite_team_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_favorite_teams DROP CONSTRAINT FK_4BCFD6256B9DD454');
        $this->addSql('ALTER TABLE user_favorite_teams DROP CONSTRAINT FK_4BCFD625296CD8AE');
        $this->addSql('DROP TABLE user_favorite_teams');
        $this->addSql('ALTER TABLE "user_data" ADD favorite_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user_data" ADD CONSTRAINT fk_d772bfaa743876c0 FOREIGN KEY (favorite_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d772bfaa743876c0 ON "user_data" (favorite_team_id)');
    }
}
