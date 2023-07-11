<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230711130642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Movie] Add unique contraint on Movie(slug).';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, slug, title, plot, released_at, poster FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, plot CLOB NOT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , poster VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO movie (id, slug, title, plot, released_at, poster) SELECT id, slug, title, plot, released_at, poster FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX_MOVIE_SLUG ON movie (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, slug, title, plot, released_at, poster FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, plot CLOB NOT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , poster VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO movie (id, slug, title, plot, released_at, poster) SELECT id, slug, title, plot, released_at, poster FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
