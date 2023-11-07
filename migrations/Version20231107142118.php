<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231107142118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon_encounter DROP FOREIGN KEY FK_583BC3EC19883967');
        $this->addSql('ALTER TABLE pokemon_encounter DROP FOREIGN KEY FK_583BC3EC2FE71C3E');
        $this->addSql('ALTER TABLE pokemon_encounter DROP FOREIGN KEY FK_583BC3ECE48FD905');
        $this->addSql('DROP TABLE pokemon_encounter');
        $this->addSql('DROP TABLE pokemon_encounter_method');
        $this->addSql('ALTER TABLE user_pokedex DROP FOREIGN KEY FK_3B3BE8AD372A5D14');
        $this->addSql('DROP INDEX IDX_3B3BE8AD372A5D14 ON user_pokedex');
        $this->addSql('ALTER TABLE user_pokedex DROP pokedex_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon_encounter (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, method_id INT NOT NULL, pokemon_id INT NOT NULL, route VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, percentage INT DEFAULT NULL, INDEX IDX_583BC3EC19883967 (method_id), INDEX IDX_583BC3EC2FE71C3E (pokemon_id), INDEX IDX_583BC3ECE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pokemon_encounter_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pokemon_encounter ADD CONSTRAINT FK_583BC3EC19883967 FOREIGN KEY (method_id) REFERENCES pokemon_encounter_method (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE pokemon_encounter ADD CONSTRAINT FK_583BC3EC2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE pokemon_encounter ADD CONSTRAINT FK_583BC3ECE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_pokedex ADD pokedex_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_pokedex ADD CONSTRAINT FK_3B3BE8AD372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3B3BE8AD372A5D14 ON user_pokedex (pokedex_id)');
    }
}
