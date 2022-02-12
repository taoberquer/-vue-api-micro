<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212205526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_31E581A0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation_category (donation_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CD0706B14DC1279C (donation_id), INDEX IDX_CD0706B112469DE2 (category_id), PRIMARY KEY(donation_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE donation_category ADD CONSTRAINT FK_CD0706B14DC1279C FOREIGN KEY (donation_id) REFERENCES donation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation_category ADD CONSTRAINT FK_CD0706B112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE piece ADD category_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B2312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_44CA0B2312469DE2 ON piece (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donation_category DROP FOREIGN KEY FK_CD0706B112469DE2');
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B2312469DE2');
        $this->addSql('ALTER TABLE donation_category DROP FOREIGN KEY FK_CD0706B14DC1279C');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE donation_category');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id');
        $this->addSql('DROP INDEX IDX_44CA0B2312469DE2 ON piece');
        $this->addSql('ALTER TABLE piece ADD type VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP category_id');
    }
}
