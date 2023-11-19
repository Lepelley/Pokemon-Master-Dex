<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119210205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokedex_pokemon ADD pokedex_id INT NOT NULL');
        $this->addSql('ALTER TABLE pokedex_pokemon ADD CONSTRAINT FK_BD0379D5372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id)');
        $this->addSql('CREATE INDEX IDX_BD0379D5372A5D14 ON pokedex_pokemon (pokedex_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokedex_pokemon DROP FOREIGN KEY FK_BD0379D5372A5D14');
        $this->addSql('DROP INDEX IDX_BD0379D5372A5D14 ON pokedex_pokemon');
        $this->addSql('ALTER TABLE pokedex_pokemon DROP pokedex_id');
    }
}
