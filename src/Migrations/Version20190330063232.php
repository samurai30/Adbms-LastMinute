<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190330063232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, subject_id INT NOT NULL, question LONGTEXT NOT NULL, marks DOUBLE PRECISION NOT NULL, INDEX IDX_8ADC54D523EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_tags (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_tags_tags (question_tags_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_69CE7CED83A79AA9 (question_tags_id), INDEX IDX_69CE7CED8D7B4FB4 (tags_id), PRIMARY KEY(question_tags_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, tag_name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(100) NOT NULL, email VARCHAR(60) NOT NULL, gender VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D523EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE question_tags_tags ADD CONSTRAINT FK_69CE7CED83A79AA9 FOREIGN KEY (question_tags_id) REFERENCES question_tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_tags_tags ADD CONSTRAINT FK_69CE7CED8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students ADD gender VARCHAR(10) NOT NULL, CHANGE password password VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_tags_tags DROP FOREIGN KEY FK_69CE7CED83A79AA9');
        $this->addSql('ALTER TABLE question_tags_tags DROP FOREIGN KEY FK_69CE7CED8D7B4FB4');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE question_tags');
        $this->addSql('DROP TABLE question_tags_tags');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('ALTER TABLE students DROP gender, CHANGE password password VARCHAR(60) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
