<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111014232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ball (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ball_game (ball_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_3D14293F6DF9098 (ball_id), INDEX IDX_3D14293E48FD905 (game_id), PRIMARY KEY(ball_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, pokedex_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_232B318C372A5D14 (pokedex_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokedex (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_regional TINYINT(1) NOT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokedex_pokemon (id INT AUTO_INCREMENT NOT NULL, pokedex_id INT NOT NULL, pokemon_id INT NOT NULL, regional_number INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BD0379D5372A5D14 (pokedex_id), INDEX IDX_BD0379D52FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_pokedex (id INT AUTO_INCREMENT NOT NULL, pokedex_id INT NOT NULL, trainer_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, is_shiny TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3B3BE8AD372A5D14 (pokedex_id), INDEX IDX_3B3BE8ADFB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_pokedex_pokemon (id INT AUTO_INCREMENT NOT NULL, capture_ball_id INT DEFAULT NULL, pokemon_id INT NOT NULL, pokedex_id INT NOT NULL, capture_game_id INT DEFAULT NULL, is_captured TINYINT(1) NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AFDF155A8472455E (capture_ball_id), UNIQUE INDEX UNIQ_AFDF155A2FE71C3E (pokemon_id), INDEX IDX_AFDF155A372A5D14 (pokedex_id), INDEX IDX_AFDF155A96220CC3 (capture_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ball_game ADD CONSTRAINT FK_3D14293F6DF9098 FOREIGN KEY (ball_id) REFERENCES ball (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ball_game ADD CONSTRAINT FK_3D14293E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id)');
        $this->addSql('ALTER TABLE pokedex_pokemon ADD CONSTRAINT FK_BD0379D5372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id)');
        $this->addSql('ALTER TABLE pokedex_pokemon ADD CONSTRAINT FK_BD0379D52FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE user_pokedex ADD CONSTRAINT FK_3B3BE8AD372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id)');
        $this->addSql('ALTER TABLE user_pokedex ADD CONSTRAINT FK_3B3BE8ADFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A8472455E FOREIGN KEY (capture_ball_id) REFERENCES ball (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokedex_pokemon (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A372A5D14 FOREIGN KEY (pokedex_id) REFERENCES user_pokedex (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A96220CC3 FOREIGN KEY (capture_game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ball_game DROP FOREIGN KEY FK_3D14293F6DF9098');
        $this->addSql('ALTER TABLE ball_game DROP FOREIGN KEY FK_3D14293E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C372A5D14');
        $this->addSql('ALTER TABLE pokedex_pokemon DROP FOREIGN KEY FK_BD0379D5372A5D14');
        $this->addSql('ALTER TABLE pokedex_pokemon DROP FOREIGN KEY FK_BD0379D52FE71C3E');
        $this->addSql('ALTER TABLE user_pokedex DROP FOREIGN KEY FK_3B3BE8AD372A5D14');
        $this->addSql('ALTER TABLE user_pokedex DROP FOREIGN KEY FK_3B3BE8ADFB08EDF6');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A8472455E');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A2FE71C3E');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A372A5D14');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A96220CC3');
        $this->addSql('DROP TABLE ball');
        $this->addSql('DROP TABLE ball_game');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE pokedex');
        $this->addSql('DROP TABLE pokedex_pokemon');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_pokedex');
        $this->addSql('DROP TABLE user_pokedex_pokemon');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
