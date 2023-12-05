<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127124443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE starting_five_aggregator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE starting_five_aggregator (id INT NOT NULL, player_id INT NOT NULL, position INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47BDF4CD99E6F5DF ON starting_five_aggregator (player_id)');
        $this->addSql('CREATE TABLE top100 (id INT NOT NULL, user_profile_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D1A278C6B9DD454 ON top100 (user_profile_id)');
        $this->addSql('COMMENT ON COLUMN top100.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN top100.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE top100_player (id INT NOT NULL, top100_id INT NOT NULL, player_id INT DEFAULT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_156C92BA9C96C46 ON top100_player (top100_id)');
        $this->addSql('CREATE INDEX IDX_156C92B99E6F5DF ON top100_player (player_id)');
        $this->addSql('COMMENT ON COLUMN top100_player.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN top100_player.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE starting_five_aggregator ADD CONSTRAINT FK_47BDF4CD99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100 ADD CONSTRAINT FK_8D1A278C6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_player ADD CONSTRAINT FK_156C92BA9C96C46 FOREIGN KEY (top100_id) REFERENCES top100 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_player ADD CONSTRAINT FK_156C92B99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_data ADD top100_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_data ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_data ALTER username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_data ADD CONSTRAINT FK_D772BFAAA9C96C46 FOREIGN KEY (top100_id) REFERENCES top100 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D772BFAAA9C96C46 ON user_data (top100_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user_data" DROP CONSTRAINT FK_D772BFAAA9C96C46');
        $this->addSql('DROP SEQUENCE starting_five_aggregator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_player_id_seq CASCADE');
        $this->addSql('ALTER TABLE starting_five_aggregator DROP CONSTRAINT FK_47BDF4CD99E6F5DF');
        $this->addSql('ALTER TABLE top100 DROP CONSTRAINT FK_8D1A278C6B9DD454');
        $this->addSql('ALTER TABLE top100_player DROP CONSTRAINT FK_156C92BA9C96C46');
        $this->addSql('ALTER TABLE top100_player DROP CONSTRAINT FK_156C92B99E6F5DF');
        $this->addSql('DROP TABLE starting_five_aggregator');
        $this->addSql('DROP TABLE top100');
        $this->addSql('DROP TABLE top100_player');
        $this->addSql('DROP INDEX UNIQ_D772BFAAA9C96C46');
        $this->addSql('ALTER TABLE "user_data" DROP top100_id');
        $this->addSql('ALTER TABLE "user_data" ALTER name TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE "user_data" ALTER username TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX uniq_d772bfaa5e237e06 ON "user_data" (name)');
    }
}
