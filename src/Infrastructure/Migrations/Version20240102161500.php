<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102161500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competition ADD league_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition ADD season_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB158AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB14EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B50A2CB158AFC4DE ON competition (league_id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB14EC001D1 ON competition (season_id)');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT fk_bd5fb8d958afc4de');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT fk_bd5fb8d94ec001d1');
        $this->addSql('DROP INDEX idx_bd5fb8d94ec001d1');
        $this->addSql('DROP INDEX idx_bd5fb8d958afc4de');
        $this->addSql('ALTER TABLE tournament DROP league_id');
        $this->addSql('ALTER TABLE tournament DROP season_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB158AFC4DE');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB14EC001D1');
        $this->addSql('DROP INDEX IDX_B50A2CB158AFC4DE');
        $this->addSql('DROP INDEX IDX_B50A2CB14EC001D1');
        $this->addSql('ALTER TABLE competition DROP league_id');
        $this->addSql('ALTER TABLE competition DROP season_id');
        $this->addSql('ALTER TABLE tournament ADD league_id INT NOT NULL');
        $this->addSql('ALTER TABLE tournament ADD season_id INT NOT NULL');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT fk_bd5fb8d958afc4de FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT fk_bd5fb8d94ec001d1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_bd5fb8d94ec001d1 ON tournament (season_id)');
        $this->addSql('CREATE INDEX idx_bd5fb8d958afc4de ON tournament (league_id)');
    }
}
