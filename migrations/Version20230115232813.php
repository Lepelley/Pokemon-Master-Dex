<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115232813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP INDEX UNIQ_AFDF155A2FE71C3E, ADD INDEX IDX_AFDF155A2FE71C3E (pokemon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP INDEX IDX_AFDF155A2FE71C3E, ADD UNIQUE INDEX UNIQ_AFDF155A2FE71C3E (pokemon_id)');
    }
}
