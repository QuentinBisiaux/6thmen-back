<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831142833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE prono_season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE prono_season (id INT NOT NULL, user_id INT NOT NULL, season_id INT NOT NULL, valid BOOLEAN NOT NULL, data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D0EC7821A76ED395 ON prono_season (user_id)');
        $this->addSql('CREATE INDEX IDX_D0EC78214EC001D1 ON prono_season (season_id)');
        $this->addSql('COMMENT ON COLUMN prono_season.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN prono_season.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE prono_season ADD CONSTRAINT FK_D0EC7821A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prono_season ADD CONSTRAINT FK_D0EC78214EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE prono_season_id_seq CASCADE');
        $this->addSql('ALTER TABLE prono_season DROP CONSTRAINT FK_D0EC7821A76ED395');
        $this->addSql('ALTER TABLE prono_season DROP CONSTRAINT FK_D0EC78214EC001D1');
        $this->addSql('DROP TABLE prono_season');
    }
}
