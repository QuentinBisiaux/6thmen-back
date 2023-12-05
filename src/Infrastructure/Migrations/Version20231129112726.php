<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129112726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE hype_score_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE hype_score (id INT NOT NULL, player_id INT NOT NULL, score INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_107D1C099E6F5DF ON hype_score (player_id)');
        $this->addSql('ALTER TABLE hype_score ADD CONSTRAINT FK_107D1C099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player ADD hype_score_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F1A9328C FOREIGN KEY (hype_score_id) REFERENCES hype_score (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65F1A9328C ON player (hype_score_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE player DROP CONSTRAINT FK_98197A65F1A9328C');
        $this->addSql('DROP SEQUENCE hype_score_id_seq CASCADE');
        $this->addSql('ALTER TABLE hype_score DROP CONSTRAINT FK_107D1C099E6F5DF');
        $this->addSql('DROP TABLE hype_score');
        $this->addSql('ALTER TABLE player DROP hype_score_id');
        $this->addSql('CREATE UNIQUE INDEX uniq_d772bfaa5e237e06 ON "user_data" (name)');
    }
}
