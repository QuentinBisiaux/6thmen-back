<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205103412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP CONSTRAINT fk_98197a65b4bb6bbc');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP INDEX idx_98197a65b4bb6bbc');
        $this->addSql('ALTER TABLE player DROP birth_place_id');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac020f64684');
        $this->addSql('DROP INDEX idx_47c69ac020f64684');
        $this->addSql('ALTER TABLE starting_five DROP ranking_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, alpha2 VARCHAR(2) NOT NULL, alpha3 VARCHAR(3) NOT NULL, code VARCHAR(3) NOT NULL, region VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN country.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN country.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE starting_five ADD ranking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac020f64684 FOREIGN KEY (ranking_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_47c69ac020f64684 ON starting_five (ranking_id)');
        $this->addSql('ALTER TABLE player ADD birth_place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT fk_98197a65b4bb6bbc FOREIGN KEY (birth_place_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_98197a65b4bb6bbc ON player (birth_place_id)');
    }
}
