<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126140847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE competition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE forecast_regular_season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE franchise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE league_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE player_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE standing_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE starting_five_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE starting_five_aggregator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE starting_five_player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_aggregator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE top100_player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tournament_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trophy_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trophy_forecast_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_data_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE competition (id INT NOT NULL, league_id INT DEFAULT NULL, season_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, games INT NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B50A2CB158AFC4DE ON competition (league_id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB14EC001D1 ON competition (season_id)');
        $this->addSql('CREATE UNIQUE INDEX competition_unique ON competition (name, league_id, season_id)');
        $this->addSql('COMMENT ON COLUMN competition.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN competition.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE forecast_regular_season (id INT NOT NULL, user_id INT NOT NULL, season_id INT NOT NULL, valid BOOLEAN NOT NULL, data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D9CD7FB9A76ED395 ON forecast_regular_season (user_id)');
        $this->addSql('CREATE INDEX IDX_D9CD7FB94EC001D1 ON forecast_regular_season (season_id)');
        $this->addSql('COMMENT ON COLUMN forecast_regular_season.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN forecast_regular_season.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE franchise (id INT NOT NULL, name VARCHAR(255) NOT NULL, tricode VARCHAR(3) NOT NULL, slug VARCHAR(255) NOT NULL, created_in DATE NOT NULL, ended_in DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE league (id INT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3EB4C3185E237E06 ON league (name)');
        $this->addSql('CREATE INDEX IDX_3EB4C318AC78BCF8 ON league (sport_id)');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, name VARCHAR(255) NOT NULL, birth_place VARCHAR(255) DEFAULT NULL, hype_score INT NOT NULL, birthday DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE player_team (id INT NOT NULL, season_id INT DEFAULT NULL, player_id INT DEFAULT NULL, team_id INT DEFAULT NULL, position TEXT DEFAULT NULL, jersey_number VARCHAR(25) NOT NULL, experience INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66FAF62C4EC001D1 ON player_team (season_id)');
        $this->addSql('CREATE INDEX IDX_66FAF62C99E6F5DF ON player_team (player_id)');
        $this->addSql('CREATE INDEX IDX_66FAF62C296CD8AE ON player_team (team_id)');
        $this->addSql('COMMENT ON COLUMN player_team.position IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE season (id INT NOT NULL, year VARCHAR(10) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sport (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE standing (id INT NOT NULL, team_id INT DEFAULT NULL, competition_id INT DEFAULT NULL, rank INT NOT NULL, victories INT NOT NULL, loses INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_619A8AD8296CD8AE ON standing (team_id)');
        $this->addSql('CREATE INDEX IDX_619A8AD87B39D312 ON standing (competition_id)');
        $this->addSql('CREATE UNIQUE INDEX standing_unique ON standing (team_id, competition_id)');
        $this->addSql('CREATE TABLE starting_five (id INT NOT NULL, user_id INT DEFAULT NULL, franchise_id INT DEFAULT NULL, valid BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47C69AC0A76ED395 ON starting_five (user_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC0523CAB89 ON starting_five (franchise_id)');
        $this->addSql('CREATE TABLE starting_five_aggregator (id INT NOT NULL, player_id INT NOT NULL, position INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47BDF4CD99E6F5DF ON starting_five_aggregator (player_id)');
        $this->addSql('CREATE TABLE starting_five_player (id INT NOT NULL, starting_five_id INT DEFAULT NULL, player_id INT DEFAULT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_715C4AB7E475622 ON starting_five_player (starting_five_id)');
        $this->addSql('CREATE INDEX IDX_715C4AB799E6F5DF ON starting_five_player (player_id)');
        $this->addSql('CREATE TABLE team (id INT NOT NULL, franchise_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, tricode VARCHAR(3) NOT NULL, slug VARCHAR(255) NOT NULL, conference VARCHAR(55) NOT NULL, created_in DATE NOT NULL, ended_in DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4E0A61F523CAB89 ON team (franchise_id)');
        $this->addSql('CREATE TABLE team_competition (team_id INT NOT NULL, competition_id INT NOT NULL, PRIMARY KEY(team_id, competition_id))');
        $this->addSql('CREATE INDEX IDX_5E3AC3FC296CD8AE ON team_competition (team_id)');
        $this->addSql('CREATE INDEX IDX_5E3AC3FC7B39D312 ON team_competition (competition_id)');
        $this->addSql('CREATE TABLE top100 (id INT NOT NULL, user_profile_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D1A278C6B9DD454 ON top100 (user_profile_id)');
        $this->addSql('CREATE TABLE top100_aggregator (id INT NOT NULL, player_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9B296BE99E6F5DF ON top100_aggregator (player_id)');
        $this->addSql('CREATE TABLE top100_player (id INT NOT NULL, top100_id INT NOT NULL, player_id INT DEFAULT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_156C92BA9C96C46 ON top100_player (top100_id)');
        $this->addSql('CREATE INDEX IDX_156C92B99E6F5DF ON top100_player (player_id)');
        $this->addSql('CREATE TABLE tournament (id INT NOT NULL, competition_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BD5FB8D97B39D312 ON tournament (competition_id)');
        $this->addSql('COMMENT ON COLUMN tournament.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tournament.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE trophy (id INT NOT NULL, competition_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_112AFAE97B39D312 ON trophy (competition_id)');
        $this->addSql('CREATE TABLE trophy_forecast (id INT NOT NULL, user_profile_id INT DEFAULT NULL, trophy_id INT DEFAULT NULL, player_id INT DEFAULT NULL, rank INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F25B5FA6B9DD454 ON trophy_forecast (user_profile_id)');
        $this->addSql('CREATE INDEX IDX_5F25B5FAF59AEEEF ON trophy_forecast (trophy_id)');
        $this->addSql('CREATE INDEX IDX_5F25B5FA99E6F5DF ON trophy_forecast (player_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, profile_id INT DEFAULT NULL, username VARCHAR(190) NOT NULL, email VARCHAR(190) DEFAULT NULL, password VARCHAR(255) NOT NULL, twitter_id VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, last_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, remember_me TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C63E6FFF ON "user" (twitter_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON "user" (profile_id)');
        $this->addSql('CREATE TABLE "user_data" (id INT NOT NULL, user_id INT DEFAULT NULL, top100_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, profile_image_url VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D772BFAAA76ED395 ON "user_data" (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D772BFAAA9C96C46 ON "user_data" (top100_id)');
        $this->addSql('CREATE TABLE user_favorite_teams (user_profile_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(user_profile_id, team_id))');
        $this->addSql('CREATE INDEX IDX_4BCFD6256B9DD454 ON user_favorite_teams (user_profile_id)');
        $this->addSql('CREATE INDEX IDX_4BCFD625296CD8AE ON user_favorite_teams (team_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
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
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB158AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB14EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forecast_regular_season ADD CONSTRAINT FK_D9CD7FB9A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forecast_regular_season ADD CONSTRAINT FK_D9CD7FB94EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT FK_66FAF62C296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT FK_619A8AD8296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT FK_619A8AD87B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0A76ED395 FOREIGN KEY (user_id) REFERENCES "user_data" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_aggregator ADD CONSTRAINT FK_47BDF4CD99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_player ADD CONSTRAINT FK_715C4AB7E475622 FOREIGN KEY (starting_five_id) REFERENCES starting_five (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_player ADD CONSTRAINT FK_715C4AB799E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_competition ADD CONSTRAINT FK_5E3AC3FC296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_competition ADD CONSTRAINT FK_5E3AC3FC7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100 ADD CONSTRAINT FK_8D1A278C6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_aggregator ADD CONSTRAINT FK_F9B296BE99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_player ADD CONSTRAINT FK_156C92BA9C96C46 FOREIGN KEY (top100_id) REFERENCES top100 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE top100_player ADD CONSTRAINT FK_156C92B99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy ADD CONSTRAINT FK_112AFAE97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FA6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FAF59AEEEF FOREIGN KEY (trophy_id) REFERENCES trophy (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trophy_forecast ADD CONSTRAINT FK_5F25B5FA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user_data" ADD CONSTRAINT FK_D772BFAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user_data" ADD CONSTRAINT FK_D772BFAAA9C96C46 FOREIGN KEY (top100_id) REFERENCES top100 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite_teams ADD CONSTRAINT FK_4BCFD6256B9DD454 FOREIGN KEY (user_profile_id) REFERENCES "user_data" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite_teams ADD CONSTRAINT FK_4BCFD625296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE competition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE forecast_regular_season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE franchise_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE league_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE player_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE player_team_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE standing_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE starting_five_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE starting_five_aggregator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE starting_five_player_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE team_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_aggregator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE top100_player_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tournament_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trophy_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trophy_forecast_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_data_id_seq" CASCADE');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB158AFC4DE');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB14EC001D1');
        $this->addSql('ALTER TABLE forecast_regular_season DROP CONSTRAINT FK_D9CD7FB9A76ED395');
        $this->addSql('ALTER TABLE forecast_regular_season DROP CONSTRAINT FK_D9CD7FB94EC001D1');
        $this->addSql('ALTER TABLE league DROP CONSTRAINT FK_3EB4C318AC78BCF8');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C4EC001D1');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C99E6F5DF');
        $this->addSql('ALTER TABLE player_team DROP CONSTRAINT FK_66FAF62C296CD8AE');
        $this->addSql('ALTER TABLE standing DROP CONSTRAINT FK_619A8AD8296CD8AE');
        $this->addSql('ALTER TABLE standing DROP CONSTRAINT FK_619A8AD87B39D312');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0A76ED395');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0523CAB89');
        $this->addSql('ALTER TABLE starting_five_aggregator DROP CONSTRAINT FK_47BDF4CD99E6F5DF');
        $this->addSql('ALTER TABLE starting_five_player DROP CONSTRAINT FK_715C4AB7E475622');
        $this->addSql('ALTER TABLE starting_five_player DROP CONSTRAINT FK_715C4AB799E6F5DF');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61F523CAB89');
        $this->addSql('ALTER TABLE team_competition DROP CONSTRAINT FK_5E3AC3FC296CD8AE');
        $this->addSql('ALTER TABLE team_competition DROP CONSTRAINT FK_5E3AC3FC7B39D312');
        $this->addSql('ALTER TABLE top100 DROP CONSTRAINT FK_8D1A278C6B9DD454');
        $this->addSql('ALTER TABLE top100_aggregator DROP CONSTRAINT FK_F9B296BE99E6F5DF');
        $this->addSql('ALTER TABLE top100_player DROP CONSTRAINT FK_156C92BA9C96C46');
        $this->addSql('ALTER TABLE top100_player DROP CONSTRAINT FK_156C92B99E6F5DF');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT FK_BD5FB8D97B39D312');
        $this->addSql('ALTER TABLE trophy DROP CONSTRAINT FK_112AFAE97B39D312');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FA6B9DD454');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FAF59AEEEF');
        $this->addSql('ALTER TABLE trophy_forecast DROP CONSTRAINT FK_5F25B5FA99E6F5DF');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE "user_data" DROP CONSTRAINT FK_D772BFAAA76ED395');
        $this->addSql('ALTER TABLE "user_data" DROP CONSTRAINT FK_D772BFAAA9C96C46');
        $this->addSql('ALTER TABLE user_favorite_teams DROP CONSTRAINT FK_4BCFD6256B9DD454');
        $this->addSql('ALTER TABLE user_favorite_teams DROP CONSTRAINT FK_4BCFD625296CD8AE');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE forecast_regular_season');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_team');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE standing');
        $this->addSql('DROP TABLE starting_five');
        $this->addSql('DROP TABLE starting_five_aggregator');
        $this->addSql('DROP TABLE starting_five_player');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_competition');
        $this->addSql('DROP TABLE top100');
        $this->addSql('DROP TABLE top100_aggregator');
        $this->addSql('DROP TABLE top100_player');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE trophy');
        $this->addSql('DROP TABLE trophy_forecast');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE "user_data"');
        $this->addSql('DROP TABLE user_favorite_teams');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
