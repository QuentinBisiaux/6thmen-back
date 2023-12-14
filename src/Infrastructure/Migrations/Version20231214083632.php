<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214083632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE trophy_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trophy_forecast_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE trophy (id INT NOT NULL, league_id INT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_112AFAE958AFC4DE ON trophy (league_id)');
        $this->addSql('COMMENT ON COLUMN trophy.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE trophy_forecast (id INT NOT NULL, user_profile_id INT NOT NULL, trophy_id INT NOT NULL, player_id INT DEFAULT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F25B5FA6B9DD454 ON trophy_forecast (user_profile_id)');
        $this->addSql('CREATE INDEX IDX_5F25B5FAF59AEEEF ON trophy_forecast (trophy_id)');
        $this->addSql('CREATE INDEX IDX_5F25B5FA99E6F5DF ON trophy_forecast (player_id)');
        $this->addSql('COMMENT ON COLUMN trophy_forecast.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN trophy_forecast.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE trophy ADD CONSTRAINT FK_112AFAE958AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FA6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FAF59AEEEF FOREIGN KEY (trophy_id) REFERENCES trophy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD experience INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player_team DROP rookie_year');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE trophy_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trophy_forecast_id_seq CASCADE');
        $this->addSql('ALTER TABLE trophy DROP CONSTRAINT FK_112AFAE958AFC4DE');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FA6B9DD454');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FAF59AEEEF');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FA99E6F5DF');
        $this->addSql('DROP TABLE trophy');
        $this->addSql('DROP TABLE trophy_forecast');
        $this->addSql('ALTER TABLE player_team ADD rookie_year BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE player_team DROP experience');
    }
}
