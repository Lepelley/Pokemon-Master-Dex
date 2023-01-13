<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113012029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A372A5D14');
        $this->addSql('DROP INDEX IDX_AFDF155A372A5D14 ON user_pokedex_pokemon');
        $this->addSql('ALTER TABLE user_pokedex_pokemon CHANGE pokedex_id user_pokedex_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A904D9BF8 FOREIGN KEY (user_pokedex_id) REFERENCES user_pokedex (id)');
        $this->addSql('CREATE INDEX IDX_AFDF155A904D9BF8 ON user_pokedex_pokemon (user_pokedex_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A904D9BF8');
        $this->addSql('DROP INDEX IDX_AFDF155A904D9BF8 ON user_pokedex_pokemon');
        $this->addSql('ALTER TABLE user_pokedex_pokemon CHANGE user_pokedex_id pokedex_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A372A5D14 FOREIGN KEY (pokedex_id) REFERENCES user_pokedex (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AFDF155A372A5D14 ON user_pokedex_pokemon (pokedex_id)');
    }
}
