<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207205816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE piece_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE piece (id INT NOT NULL, quality INT NOT NULL, type VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, damage VARCHAR(255) NOT NULL, sale BOOLEAN NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE piece_id_seq CASCADE');
        $this->addSql('DROP TABLE piece');
    }
}
