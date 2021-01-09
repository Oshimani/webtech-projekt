<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109183446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__poem AS SELECT id, author, content, praise, created, title FROM poem');
        $this->addSql('DROP TABLE poem');
        $this->addSql('CREATE TABLE poem (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author VARCHAR(255) NOT NULL COLLATE BINARY, praise INTEGER DEFAULT 0 NOT NULL, created DATE DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL)');
        $this->addSql('INSERT INTO poem (id, author, content, praise, created, title) SELECT id, author, content, praise, created, title FROM __temp__poem');
        $this->addSql('DROP TABLE __temp__poem');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__poem AS SELECT id, author, content, praise, created, title FROM poem');
        $this->addSql('DROP TABLE poem');
        $this->addSql('CREATE TABLE poem (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author VARCHAR(255) NOT NULL, praise INTEGER DEFAULT 0 NOT NULL, created DATE DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO poem (id, author, content, praise, created, title) SELECT id, author, content, praise, created, title FROM __temp__poem');
        $this->addSql('DROP TABLE __temp__poem');
    }
}
