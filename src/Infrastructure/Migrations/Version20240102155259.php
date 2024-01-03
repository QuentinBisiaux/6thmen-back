<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102155259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE competition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tournament_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE competition (id INT NOT NULL, name VARCHAR(255) NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN competition.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN competition.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tournament (id INT NOT NULL, competition_id INT NOT NULL, league_id INT NOT NULL, season_id INT NOT NULL, name VARCHAR(255) NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BD5FB8D97B39D312 ON tournament (competition_id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D958AFC4DE ON tournament (league_id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D94EC001D1 ON tournament (season_id)');
        $this->addSql('COMMENT ON COLUMN tournament.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tournament.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D958AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D94EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE competition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tournament_id_seq CASCADE');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT FK_BD5FB8D97B39D312');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT FK_BD5FB8D958AFC4DE');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT FK_BD5FB8D94EC001D1');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE tournament');
    }
}
