<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129135326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE starting_five_player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE starting_five_player (id INT NOT NULL, starting_five_id INT NOT NULL, player_id INT DEFAULT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_715C4AB7E475622 ON starting_five_player (starting_five_id)');
        $this->addSql('CREATE INDEX IDX_715C4AB799E6F5DF ON starting_five_player (player_id)');
        $this->addSql('COMMENT ON COLUMN starting_five_player.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN starting_five_player.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE starting_five_player ADD CONSTRAINT FK_715C4AB7E475622 FOREIGN KEY (starting_five_id) REFERENCES starting_five (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five_player ADD CONSTRAINT FK_715C4AB799E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac0fec7c003');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac06ca29a61');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac016ed395a');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac012c72fec');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac05932f377');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC0A76ED395');
        $this->addSql('DROP INDEX idx_47c69ac05932f377');
        $this->addSql('DROP INDEX idx_47c69ac012c72fec');
        $this->addSql('DROP INDEX idx_47c69ac016ed395a');
        $this->addSql('DROP INDEX idx_47c69ac06ca29a61');
        $this->addSql('DROP INDEX idx_47c69ac0fec7c003');
        $this->addSql('ALTER TABLE starting_five ADD ranking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE starting_five DROP point_guard_id');
        $this->addSql('ALTER TABLE starting_five DROP guard_id');
        $this->addSql('ALTER TABLE starting_five DROP forward_id');
        $this->addSql('ALTER TABLE starting_five DROP small_forward_id');
        $this->addSql('ALTER TABLE starting_five DROP center_id');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC020F64684 FOREIGN KEY (ranking_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT FK_47C69AC0A76ED395 FOREIGN KEY (user_id) REFERENCES "user_data" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_47C69AC020F64684 ON starting_five (ranking_id)');
        $this->addSql('DROP INDEX uniq_d772bfaa5e237e06');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE starting_five_player_id_seq CASCADE');
        $this->addSql('ALTER TABLE starting_five_player DROP CONSTRAINT FK_715C4AB7E475622');
        $this->addSql('ALTER TABLE starting_five_player DROP CONSTRAINT FK_715C4AB799E6F5DF');
        $this->addSql('DROP TABLE starting_five_player');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT FK_47C69AC020F64684');
        $this->addSql('ALTER TABLE starting_five DROP CONSTRAINT fk_47c69ac0a76ed395');
        $this->addSql('DROP INDEX IDX_47C69AC020F64684');
        $this->addSql('ALTER TABLE starting_five ADD guard_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE starting_five ADD forward_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE starting_five ADD small_forward_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE starting_five ADD center_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE starting_five RENAME COLUMN ranking_id TO point_guard_id');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac0fec7c003 FOREIGN KEY (point_guard_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac06ca29a61 FOREIGN KEY (guard_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac016ed395a FOREIGN KEY (forward_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac012c72fec FOREIGN KEY (small_forward_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac05932f377 FOREIGN KEY (center_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE starting_five ADD CONSTRAINT fk_47c69ac0a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_47c69ac05932f377 ON starting_five (center_id)');
        $this->addSql('CREATE INDEX idx_47c69ac012c72fec ON starting_five (small_forward_id)');
        $this->addSql('CREATE INDEX idx_47c69ac016ed395a ON starting_five (forward_id)');
        $this->addSql('CREATE INDEX idx_47c69ac06ca29a61 ON starting_five (guard_id)');
        $this->addSql('CREATE INDEX idx_47c69ac0fec7c003 ON starting_five (point_guard_id)');
    }
}
