<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705161343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE player_teams_id_seq CASCADE');
        $this->addSql('CREATE TABLE player_team (id SERIAL NOT NULL, season_id INT NOT NULL, player_id INT NOT NULL, team_id INT NOT NULL, position VARCHAR(50) DEFAULT NULL, jersey_number VARCHAR(50) DEFAULT NULL, rookie_year BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66FAF62C4EC001D1 ON player_team (season_id)');
        $this->addSql('CREATE INDEX IDX_66FAF62C99E6F5DF ON player_team (player_id)');
        $this->addSql('CREATE INDEX IDX_66FAF62C296CD8AE ON player_team (team_id)');
        $this->addSql('COMMENT ON COLUMN player_team.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN player_team.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_teams DROP CONSTRAINT fk_29b0591e4ec001d1');
        $this->addSql('ALTER TABLE player_teams DROP CONSTRAINT fk_29b0591e99e6f5df');
        $this->addSql('ALTER TABLE player_teams DROP CONSTRAINT fk_29b0591e296cd8ae');
        $this->addSql('DROP TABLE player_teams');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE player_teams_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE player_teams (id SERIAL NOT NULL, season_id INT NOT NULL, player_id INT NOT NULL, team_id INT NOT NULL, "position" VARCHAR(5) DEFAULT NULL, jersey_number VARCHAR(255) NOT NULL, rookie_year BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_29b0591e296cd8ae ON player_teams (team_id)');
        $this->addSql('CREATE INDEX idx_29b0591e99e6f5df ON player_teams (player_id)');
        $this->addSql('CREATE INDEX idx_29b0591e4ec001d1 ON player_teams (season_id)');
        $this->addSql('COMMENT ON COLUMN player_teams.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN player_teams.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE player_teams ADD CONSTRAINT fk_29b0591e4ec001d1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_teams ADD CONSTRAINT fk_29b0591e99e6f5df FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_teams ADD CONSTRAINT fk_29b0591e296cd8ae FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C4EC001D1');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C99E6F5DF');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C296CD8AE');
        $this->addSql('DROP TABLE player_team');
        $this->addSql('CREATE UNIQUE INDEX unique_standing ON standing (league_id, season_id, team_id, rank)');
    }
}
