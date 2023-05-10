<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510211936 extends AbstractMigration
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
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, release_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokedex (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_regional TINYINT(1) NOT NULL, is_shiny_unavailable TINYINT(1) NOT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokedex_game (pokedex_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_7132EA2C372A5D14 (pokedex_id), INDEX IDX_7132EA2CE48FD905 (game_id), PRIMARY KEY(pokedex_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokedex_pokemon_form (pokedex_id INT NOT NULL, pokemon_form_id INT NOT NULL, INDEX IDX_BA2FCC7372A5D14 (pokedex_id), INDEX IDX_BA2FCC7339CE7EC (pokemon_form_id), PRIMARY KEY(pokedex_id, pokemon_form_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokedex_pokemon (id INT AUTO_INCREMENT NOT NULL, pokedex_id INT NOT NULL, pokemon_id INT NOT NULL, regional_number INT DEFAULT NULL, specific_name VARCHAR(255) DEFAULT NULL, specific_image VARCHAR(255) DEFAULT NULL, specific_shiny_image VARCHAR(255) DEFAULT NULL, is_shiny_unavailable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BD0379D5372A5D14 (pokedex_id), INDEX IDX_BD0379D52FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, national_number INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_shiny VARCHAR(255) DEFAULT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_form (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_shiny VARCHAR(255) DEFAULT NULL, is_gender_difference TINYINT(1) NOT NULL, national_number INT DEFAULT NULL, is_online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6E21830C2FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_pokedex (id INT AUTO_INCREMENT NOT NULL, pokedex_id INT NOT NULL, trainer_id INT NOT NULL, base_game_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, is_shiny TINYINT(1) NOT NULL, prevent_spoil TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3B3BE8AD372A5D14 (pokedex_id), INDEX IDX_3B3BE8ADFB08EDF6 (trainer_id), INDEX IDX_3B3BE8ADD0896061 (base_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_pokedex_pokemon (id INT AUTO_INCREMENT NOT NULL, capture_ball_id INT DEFAULT NULL, capture_game_id INT DEFAULT NULL, pokedex_id INT NOT NULL, pokemon_id INT DEFAULT NULL, form_id INT DEFAULT NULL, is_captured TINYINT(1) NOT NULL, notes LONGTEXT DEFAULT NULL, is_male TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AFDF155A8472455E (capture_ball_id), INDEX IDX_AFDF155A96220CC3 (capture_game_id), INDEX IDX_AFDF155A372A5D14 (pokedex_id), INDEX IDX_AFDF155A2FE71C3E (pokemon_id), INDEX IDX_AFDF155A5FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ball_game ADD CONSTRAINT FK_3D14293F6DF9098 FOREIGN KEY (ball_id) REFERENCES ball (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ball_game ADD CONSTRAINT FK_3D14293E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokedex_game ADD CONSTRAINT FK_7132EA2C372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokedex_game ADD CONSTRAINT FK_7132EA2CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokedex_pokemon_form ADD CONSTRAINT FK_BA2FCC7372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokedex_pokemon_form ADD CONSTRAINT FK_BA2FCC7339CE7EC FOREIGN KEY (pokemon_form_id) REFERENCES pokemon_form (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokedex_pokemon ADD CONSTRAINT FK_BD0379D5372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id)');
        $this->addSql('ALTER TABLE pokedex_pokemon ADD CONSTRAINT FK_BD0379D52FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE pokemon_form ADD CONSTRAINT FK_6E21830C2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE user_pokedex ADD CONSTRAINT FK_3B3BE8AD372A5D14 FOREIGN KEY (pokedex_id) REFERENCES pokedex (id)');
        $this->addSql('ALTER TABLE user_pokedex ADD CONSTRAINT FK_3B3BE8ADFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_pokedex ADD CONSTRAINT FK_3B3BE8ADD0896061 FOREIGN KEY (base_game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A8472455E FOREIGN KEY (capture_ball_id) REFERENCES ball (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A96220CC3 FOREIGN KEY (capture_game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A372A5D14 FOREIGN KEY (pokedex_id) REFERENCES user_pokedex (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokedex_pokemon (id)');
        $this->addSql('ALTER TABLE user_pokedex_pokemon ADD CONSTRAINT FK_AFDF155A5FF69B7D FOREIGN KEY (form_id) REFERENCES pokemon_form (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ball_game DROP FOREIGN KEY FK_3D14293F6DF9098');
        $this->addSql('ALTER TABLE ball_game DROP FOREIGN KEY FK_3D14293E48FD905');
        $this->addSql('ALTER TABLE pokedex_game DROP FOREIGN KEY FK_7132EA2C372A5D14');
        $this->addSql('ALTER TABLE pokedex_game DROP FOREIGN KEY FK_7132EA2CE48FD905');
        $this->addSql('ALTER TABLE pokedex_pokemon_form DROP FOREIGN KEY FK_BA2FCC7372A5D14');
        $this->addSql('ALTER TABLE pokedex_pokemon_form DROP FOREIGN KEY FK_BA2FCC7339CE7EC');
        $this->addSql('ALTER TABLE pokedex_pokemon DROP FOREIGN KEY FK_BD0379D5372A5D14');
        $this->addSql('ALTER TABLE pokedex_pokemon DROP FOREIGN KEY FK_BD0379D52FE71C3E');
        $this->addSql('ALTER TABLE pokemon_form DROP FOREIGN KEY FK_6E21830C2FE71C3E');
        $this->addSql('ALTER TABLE user_pokedex DROP FOREIGN KEY FK_3B3BE8AD372A5D14');
        $this->addSql('ALTER TABLE user_pokedex DROP FOREIGN KEY FK_3B3BE8ADFB08EDF6');
        $this->addSql('ALTER TABLE user_pokedex DROP FOREIGN KEY FK_3B3BE8ADD0896061');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A8472455E');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A96220CC3');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A372A5D14');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A2FE71C3E');
        $this->addSql('ALTER TABLE user_pokedex_pokemon DROP FOREIGN KEY FK_AFDF155A5FF69B7D');
        $this->addSql('DROP TABLE ball');
        $this->addSql('DROP TABLE ball_game');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE pokedex');
        $this->addSql('DROP TABLE pokedex_game');
        $this->addSql('DROP TABLE pokedex_pokemon_form');
        $this->addSql('DROP TABLE pokedex_pokemon');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_form');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_pokedex');
        $this->addSql('DROP TABLE user_pokedex_pokemon');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
