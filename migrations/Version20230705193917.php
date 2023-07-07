<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705193917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE standing_draft_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE standing_draft (id INT NOT NULL, league_id INT NOT NULL, season_id INT NOT NULL, team_id INT NOT NULL, victory INT NOT NULL, loses INT NOT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, odds DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5297ECAE58AFC4DE ON standing_draft (league_id)');
        $this->addSql('CREATE INDEX IDX_5297ECAE4EC001D1 ON standing_draft (season_id)');
        $this->addSql('CREATE INDEX IDX_5297ECAE296CD8AE ON standing_draft (team_id)');
        $this->addSql('COMMENT ON COLUMN standing_draft.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN standing_draft.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT FK_5297ECAE58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT FK_5297ECAE4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT FK_5297ECAE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX unique_standing_draft ON standing_draft (league_id, season_id, team_id, rank)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE standing_draft_id_seq CASCADE');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT FK_5297ECAE58AFC4DE');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT FK_5297ECAE4EC001D1');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT FK_5297ECAE296CD8AE');
        $this->addSql('DROP TABLE standing_draft');

    }
}
