<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205115216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE forecast_regular_season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hype_score_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE league_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE player_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE standing_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE standing_draft_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE starting_five_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE starting_five_aggregator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE starting_five_player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_aggregator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_data_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE forecast_regular_season (id INT NOT NULL, user_id INT NOT NULL, season_id INT NOT NULL, valid BOOLEAN NOT NULL, data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D9CD7FB9A76ED395 ON forecast_regular_season (user_id)');
        $this->addSql('CREATE INDEX IDX_D9CD7FB94EC001D1 ON forecast_regular_season (season_id)');
        $this->addSql('COMMENT ON COLUMN forecast_regular_season.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN forecast_regular_season.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE hype_score (id INT NOT NULL, player_id INT NOT NULL, score INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_107D1C099E6F5DF ON hype_score (player_id)');
        $this->addSql('CREATE TABLE league (id INT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3EB4C318AC78BCF8 ON league (sport_id)');
        $this->addSql('COMMENT ON COLUMN league.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN league.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, hype_score_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, birth_place VARCHAR(255) DEFAULT NULL, birthday TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65F1A9328C ON player (hype_score_id)');
        $this->addSql('COMMENT ON COLUMN player.birthday IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN player.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN player.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE player_team (id INT NOT NULL, season_id INT NOT NULL, player_id INT NOT NULL, team_id INT NOT NULL, position VARCHAR(50) DEFAULT NULL, jersey_number VARCHAR(50) DEFAULT NULL, rookie_year BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66FAF62C4EC001D1 ON player_team (season_id)');
        $this->addSql('CREATE INDEX IDX_66FAF62C99E6F5DF ON player_team (player_id)');
        $this->addSql('CREATE INDEX IDX_66FAF62C296CD8AE ON player_team (team_id)');
        $this->addSql('COMMENT ON COLUMN player_team.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN player_team.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE season (id INT NOT NULL, year VARCHAR(10) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN season.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN season.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE sport (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN sport.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN sport.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE standing (id INT NOT NULL, league_id INT NOT NULL, season_id INT NOT NULL, team_id INT NOT NULL, victory INT NOT NULL, loses INT NOT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_619A8AD858AFC4DE ON standing (league_id)');
        $this->addSql('CREATE INDEX IDX_619A8AD84EC001D1 ON standing (season_id)');
        $this->addSql('CREATE INDEX IDX_619A8AD8296CD8AE ON standing (team_id)');
        $this->addSql('COMMENT ON COLUMN standing.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN standing.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE standing_draft (id INT NOT NULL, league_id INT NOT NULL, season_id INT NOT NULL, team_id INT NOT NULL, victory INT NOT NULL, loses INT NOT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, odds DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5297ECAE58AFC4DE ON standing_draft (league_id)');
        $this->addSql('CREATE INDEX IDX_5297ECAE4EC001D1 ON standing_draft (season_id)');
        $this->addSql('CREATE INDEX IDX_5297ECAE296CD8AE ON standing_draft (team_id)');
        $this->addSql('COMMENT ON COLUMN standing_draft.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN standing_draft.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE starting_five (id INT NOT NULL, user_id INT NOT NULL, team_id INT NOT NULL, valid BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47C69AC0A76ED395 ON starting_five (user_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC0296CD8AE ON starting_five (team_id)');
        $this->addSql('COMMENT ON COLUMN starting_five.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN starting_five.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE starting_five_aggregator (id INT NOT NULL, player_id INT NOT NULL, position INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47BDF4CD99E6F5DF ON starting_five_aggregator (player_id)');
        $this->addSql('CREATE TABLE starting_five_player (id INT NOT NULL, starting_five_id INT NOT NULL, player_id INT DEFAULT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_715C4AB7E475622 ON starting_five_player (starting_five_id)');
        $this->addSql('CREATE INDEX IDX_715C4AB799E6F5DF ON starting_five_player (player_id)');
        $this->addSql('COMMENT ON COLUMN starting_five_player.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN starting_five_player.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE team (id INT NOT NULL, sister_team_id INT DEFAULT NULL, league_id INT NOT NULL, name VARCHAR(255) NOT NULL, tricode VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, conference VARCHAR(55) NOT NULL, created_in DATE NOT NULL, ended_in DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4E0A61F2618F47 ON team (sister_team_id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F58AFC4DE ON team (league_id)');
        $this->addSql('COMMENT ON COLUMN team.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN team.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE top100 (id INT NOT NULL, user_profile_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D1A278C6B9DD454 ON top100 (user_profile_id)');
        $this->addSql('COMMENT ON COLUMN top100.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN top100.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE top100_aggregator (id INT NOT NULL, player_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9B296BE99E6F5DF ON top100_aggregator (player_id)');
        $this->addSql('CREATE TABLE top100_player (id INT NOT NULL, top100_id INT NOT NULL, player_id INT DEFAULT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_156C92BA9C96C46 ON top100_player (top100_id)');
        $this->addSql('CREATE INDEX IDX_156C92B99E6F5DF ON top100_player (player_id)');
        $this->addSql('COMMENT ON COLUMN top100_player.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN top100_player.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, profile_id INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, twitter_id VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C63E6FFF ON "user" (twitter_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON "user" (profile_id)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user_data" (id INT NOT NULL, user_id INT NOT NULL, top100_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, profile_image_url VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, raw_data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D772BFAAF85E0677 ON "user_data" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D772BFAAA76ED395 ON "user_data" (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D772BFAAA9C96C46 ON "user_data" (top100_id)');
        $this->addSql('COMMENT ON COLUMN "user_data".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_data".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_favorite_teams (user_profile_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(user_profile_id, team_id))');
        $this->addSql('CREATE INDEX IDX_4BCFD6256B9DD454 ON user_favorite_teams (user_profile_id)');
        $this->addSql('CREATE INDEX IDX_4BCFD625296CD8AE ON user_favorite_teams (team_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT unique_standing UNIQUE (league_id, season_id, team_id, rank)');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT unique_standing_draft UNIQUE (league_id, season_id, team_id, rank)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE forecast_regular_season ADD CONSTRAINT FK_D9CD7FB9A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forecast_regular_season ADD CONSTRAINT FK_D9CD7FB94EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hype_score ADD CONSTRAINT FK_107D1C099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F1A9328C FOREIGN KEY (hype_score_id) REFERENCES hype_score (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT FK_619A8AD858AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT FK_619A8AD84EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT FK_619A8AD8296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT FK_5297ECAE58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT FK_5297ECAE4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing_draft ADD CONSTRAINT FK_5297ECAE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0A76ED395 FOREIGN KEY (user_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_aggregator ADD CONSTRAINT FK_47BDF4CD99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_player ADD CONSTRAINT FK_715C4AB7E475622 FOREIGN KEY (starting_five_id) REFERENCES starting_five (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_player ADD CONSTRAINT FK_715C4AB799E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F2618F47 FOREIGN KEY (sister_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100 ADD CONSTRAINT FK_8D1A278C6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_aggregator ADD CONSTRAINT FK_F9B296BE99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_player ADD CONSTRAINT FK_156C92BA9C96C46 FOREIGN KEY (top100_id) REFERENCES top100 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_player ADD CONSTRAINT FK_156C92B99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user_data" ADD CONSTRAINT FK_D772BFAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user_data" ADD CONSTRAINT FK_D772BFAAA9C96C46 FOREIGN KEY (top100_id) REFERENCES top100 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite_teams ADD CONSTRAINT FK_4BCFD6256B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite_teams ADD CONSTRAINT FK_4BCFD625296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE forecast_regular_season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hype_score_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE league_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE player_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE player_team_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE standing_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE standing_draft_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE starting_five_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE starting_five_aggregator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE starting_five_player_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE team_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_aggregator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_player_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_data_id_seq" CASCADE');
        $this->addSql('ALTER TABLE forecast_regular_season DROP CONSTRAINT FK_D9CD7FB9A76ED395');
        $this->addSql('ALTER TABLE forecast_regular_season DROP CONSTRAINT FK_D9CD7FB94EC001D1');
        $this->addSql('ALTER TABLE hype_score DROP CONSTRAINT FK_107D1C099E6F5DF');
        $this->addSql('ALTER TABLE league DROP CONSTRAINT FK_3EB4C318AC78BCF8');
        $this->addSql('ALTER TABLE player DROP CONSTRAINT FK_98197A65F1A9328C');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C4EC001D1');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C99E6F5DF');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C296CD8AE');
        $this->addSql('ALTER TABLE standing DROP CONSTRAINT FK_619A8AD858AFC4DE');
        $this->addSql('ALTER TABLE standing DROP CONSTRAINT FK_619A8AD84EC001D1');
        $this->addSql('ALTER TABLE standing DROP CONSTRAINT FK_619A8AD8296CD8AE');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT FK_5297ECAE58AFC4DE');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT FK_5297ECAE4EC001D1');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT FK_5297ECAE296CD8AE');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0A76ED395');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0296CD8AE');
        $this->addSql('ALTER TABLE starting_five_aggregator DROP CONSTRAINT FK_47BDF4CD99E6F5DF');
        $this->addSql('ALTER TABLE starting_five_player DROP CONSTRAINT FK_715C4AB7E475622');
        $this->addSql('ALTER TABLE starting_five_player DROP CONSTRAINT FK_715C4AB799E6F5DF');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61F2618F47');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61F58AFC4DE');
        $this->addSql('ALTER TABLE top100 DROP CONSTRAINT FK_8D1A278C6B9DD454');
        $this->addSql('ALTER TABLE top100_aggregator DROP CONSTRAINT FK_F9B296BE99E6F5DF');
        $this->addSql('ALTER TABLE top100_player DROP CONSTRAINT FK_156C92BA9C96C46');
        $this->addSql('ALTER TABLE top100_player DROP CONSTRAINT FK_156C92B99E6F5DF');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE "user_data" DROP CONSTRAINT FK_D772BFAAA76ED395');
        $this->addSql('ALTER TABLE "user_data" DROP CONSTRAINT FK_D772BFAAA9C96C46');
        $this->addSql('ALTER TABLE user_favorite_teams DROP CONSTRAINT FK_4BCFD6256B9DD454');
        $this->addSql('ALTER TABLE user_favorite_teams DROP CONSTRAINT FK_4BCFD625296CD8AE');
        $this->addSql('ALTER TABLE standing DROP CONSTRAINT unique_standing');
        $this->addSql('ALTER TABLE standing_draft DROP CONSTRAINT unique_standing_draft');
        $this->addSql('DROP TABLE forecast_regular_season');
        $this->addSql('DROP TABLE hype_score');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_team');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE standing');
        $this->addSql('DROP TABLE standing_draft');
        $this->addSql('DROP TABLE starting_five');
        $this->addSql('DROP TABLE starting_five_aggregator');
        $this->addSql('DROP TABLE starting_five_player');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE top100');
        $this->addSql('DROP TABLE top100_aggregator');
        $this->addSql('DROP TABLE top100_player');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE "user_data"');
        $this->addSql('DROP TABLE user_favorite_teams');
        $this->addSql('DROP TABLE messenger_messages');
    }
}