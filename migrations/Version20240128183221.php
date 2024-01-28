<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128183221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wordle_configuration ADD solution VARCHAR(255) NOT NULL, ADD max_tries INT NOT NULL, CHANGE max_guess author_id INT NOT NULL');
        $this->addSql('ALTER TABLE wordle_configuration ADD CONSTRAINT FK_F1C2DCC7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F1C2DCC7F675F31B ON wordle_configuration (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wordle_configuration DROP FOREIGN KEY FK_F1C2DCC7F675F31B');
        $this->addSql('DROP INDEX IDX_F1C2DCC7F675F31B ON wordle_configuration');
        $this->addSql('ALTER TABLE wordle_configuration ADD max_guess INT NOT NULL, DROP author_id, DROP solution, DROP max_tries');
    }
}
