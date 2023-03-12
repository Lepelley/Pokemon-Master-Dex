<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312104655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD form_id INT DEFAULT NULL, ADD is_male TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A5FF69B7D FOREIGN KEY (form_id) REFERENCES pokemon_form (id)');
        $this->addSql('CREATE INDEX IDX_AFDF155A5FF69B7D ON user_pokedex_pokemon (form_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A5FF69B7D');
        $this->addSql('DROP INDEX IDX_AFDF155A5FF69B7D ON user_pokedex_pokemon');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP form_id, DROP is_male');
    }
}
