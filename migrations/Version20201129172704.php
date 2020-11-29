<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129172704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, course_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_ue TINYINT(1) NOT NULL, is_option_group TINYINT(1) NOT NULL, INDEX IDX_169E6FB9727ACA70 (parent_id), INDEX IDX_169E6FB9591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, course_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, overall SMALLINT NOT NULL, difficulty SMALLINT NOT NULL, interest SMALLINT NOT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_D2294458F675F31B (author_id), INDEX IDX_D2294458591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles JSON DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, promo INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9727ACA70 FOREIGN KEY (parent_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9727ACA70');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9591CC992');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458591CC992');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458F675F31B');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE `user`');
    }
}
