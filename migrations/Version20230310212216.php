<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310212216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokedex_pokemon_form (pokedex_id INT NOT NULL, pokemon_form_id INT NOT NULL, INDEX IDX_BA2FCC7372A5D14 (pokedex_id), INDEX IDX_BA2FCC7339CE7EC (pokemon_form_id), PRIMARY KEY(pokedex_id, pokemon_form_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokedex_pokemon_form ADD CONSTRAINT FK_BA2FCC7372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokedex_pokemon_form ADD CONSTRAINT FK_BA2FCC7339CE7EC FOREIGN KEY (pokemon_form_id) REFERENCES pokemon_form (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokedex_pokemon_form DROP FOREIGN KEY FK_BA2FCC7372A5D14');
        $this->addSql('ALTER TABLE pokedex_pokemon_form DROP FOREIGN KEY FK_BA2FCC7339CE7EC');
        $this->addSql('DROP TABLE pokedex_pokemon_form');
    }
}
