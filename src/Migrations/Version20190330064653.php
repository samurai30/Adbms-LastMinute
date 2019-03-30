<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190330064653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_tags_tags DROP FOREIGN KEY FK_69CE7CED83A79AA9');
        $this->addSql('CREATE TABLE questions_tags (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags_questions (tags_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_EEDD6A898D7B4FB4 (tags_id), INDEX IDX_EEDD6A89BCB134CE (questions_id), PRIMARY KEY(tags_id, questions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tags_questions ADD CONSTRAINT FK_EEDD6A898D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_questions ADD CONSTRAINT FK_EEDD6A89BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE question_tags');
        $this->addSql('DROP TABLE question_tags_tags');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question_tags (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE question_tags_tags (question_tags_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_69CE7CED8D7B4FB4 (tags_id), INDEX IDX_69CE7CED83A79AA9 (question_tags_id), PRIMARY KEY(question_tags_id, tags_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE question_tags_tags ADD CONSTRAINT FK_69CE7CED83A79AA9 FOREIGN KEY (question_tags_id) REFERENCES question_tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_tags_tags ADD CONSTRAINT FK_69CE7CED8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE questions_tags');
        $this->addSql('DROP TABLE tags_questions');
    }
}
