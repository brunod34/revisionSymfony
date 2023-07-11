<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230711213042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, released_at, text, score FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movie_id INTEGER DEFAULT NULL, released_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , text CLOB NOT NULL, score VARCHAR(255) NOT NULL, CONSTRAINT FK_9474526C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, released_at, text, score) SELECT id, released_at, text, score FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C8F93B6FC ON comment (movie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, released_at, text, score FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, released_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , text CLOB NOT NULL, score VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO comment (id, released_at, text, score) SELECT id, released_at, text, score FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
    }
}
