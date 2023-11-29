<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129104450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE top100_aggregator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE top100_aggregator (id INT NOT NULL, player_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9B296BE99E6F5DF ON top100_aggregator (player_id)');
        $this->addSql('ALTER TABLE top100_aggregator ADD CONSTRAINT FK_F9B296BE99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE top100_aggregator_id_seq CASCADE');
        $this->addSql('ALTER TABLE top100_aggregator DROP CONSTRAINT FK_F9B296BE99E6F5DF');
        $this->addSql('DROP TABLE top100_aggregator');
    }
}
