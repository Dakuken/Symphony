<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116201803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wordle_configuration (id INT AUTO_INCREMENT NOT NULL, word_length INT NOT NULL, max_guess INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wordle_dictionary (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wordle_game (id INT AUTO_INCREMENT NOT NULL, wordle_configuration_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_BA85E281AA466C8B (wordle_configuration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wordle_game_players (wordle_game_id INT NOT NULL, wordle_player_id INT NOT NULL, INDEX IDX_4DA2057F772C52FC (wordle_game_id), INDEX IDX_4DA2057F26F26620 (wordle_player_id), PRIMARY KEY(wordle_game_id, wordle_player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wordle_guess (id INT AUTO_INCREMENT NOT NULL, guessed_word VARCHAR(255) NOT NULL, guess_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wordle_player (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wordle_solution (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wordle_game ADD CONSTRAINT FK_BA85E281AA466C8B FOREIGN KEY (wordle_configuration_id) REFERENCES wordle_configuration (id)');
        $this->addSql('ALTER TABLE wordle_game_players ADD CONSTRAINT FK_4DA2057F772C52FC FOREIGN KEY (wordle_game_id) REFERENCES wordle_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wordle_game_players ADD CONSTRAINT FK_4DA2057F26F26620 FOREIGN KEY (wordle_player_id) REFERENCES wordle_player (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wordle_game DROP FOREIGN KEY FK_BA85E281AA466C8B');
        $this->addSql('ALTER TABLE wordle_game_players DROP FOREIGN KEY FK_4DA2057F772C52FC');
        $this->addSql('ALTER TABLE wordle_game_players DROP FOREIGN KEY FK_4DA2057F26F26620');
        $this->addSql('DROP TABLE wordle_configuration');
        $this->addSql('DROP TABLE wordle_dictionary');
        $this->addSql('DROP TABLE wordle_game');
        $this->addSql('DROP TABLE wordle_game_players');
        $this->addSql('DROP TABLE wordle_guess');
        $this->addSql('DROP TABLE wordle_player');
        $this->addSql('DROP TABLE wordle_solution');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
