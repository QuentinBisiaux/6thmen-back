<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115171241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs;
        $this->addSql('ALTER TABLE trophy_forecast ADD season_id INT NOT NULL');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5F25B5FA4EC001D1 ON trophy_forecast (season_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FA4EC001D1');
        $this->addSql('DROP INDEX IDX_5F25B5FA4EC001D1');
        $this->addSql('ALTER TABLE trophy_forecast DROP season_id');
    }
}
