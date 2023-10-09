<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009133911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE starting_five_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE starting_five (id INT NOT NULL, user_id INT NOT NULL, team_id INT NOT NULL, point_guard_id INT NOT NULL, guard_id INT NOT NULL, forward_id INT NOT NULL, small_forward_id INT NOT NULL, center_id INT NOT NULL, valid BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47C69AC0A76ED395 ON starting_five (user_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC0296CD8AE ON starting_five (team_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC0FEC7C003 ON starting_five (point_guard_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC06CA29A61 ON starting_five (guard_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC016ED395A ON starting_five (forward_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC012C72FEC ON starting_five (small_forward_id)');
        $this->addSql('CREATE INDEX IDX_47C69AC05932F377 ON starting_five (center_id)');
        $this->addSql('COMMENT ON COLUMN starting_five.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN starting_five.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0296CD8AE FOREIGN KEY (team_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0FEC7C003 FOREIGN KEY (point_guard_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC06CA29A61 FOREIGN KEY (guard_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC016ED395A FOREIGN KEY (forward_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC012C72FEC FOREIGN KEY (small_forward_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC05932F377 FOREIGN KEY (center_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE player_team ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_data DROP CONSTRAINT FK_D772BFAAA76ED395');
        $this->addSql('ALTER TABLE user_data ADD CONSTRAINT FK_D772BFAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE starting_five_id_seq CASCADE');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0A76ED395');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0296CD8AE');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0FEC7C003');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC06CA29A61');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC016ED395A');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC012C72FEC');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC05932F377');
        $this->addSql('DROP TABLE starting_five');
        $this->addSql('ALTER TABLE "user_data" DROP CONSTRAINT fk_d772bfaaa76ed395');
        $this->addSql('ALTER TABLE "user_data" ADD CONSTRAINT fk_d772bfaaa76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE SEQUENCE player_id_seq');
        $this->addSql('SELECT setval(\'player_id_seq\', (SELECT MAX(id) FROM player))');
        $this->addSql('ALTER TABLE player ALTER id SET DEFAULT nextval(\'player_id_seq\')');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649ccfa12b8');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649ccfa12b8 FOREIGN KEY (profile_id) REFERENCES user_data (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE SEQUENCE player_team_id_seq');
        $this->addSql('SELECT setval(\'player_team_id_seq\', (SELECT MAX(id) FROM player_team))');
        $this->addSql('ALTER TABLE player_team ALTER id SET DEFAULT nextval(\'player_team_id_seq\')');
    }
}
