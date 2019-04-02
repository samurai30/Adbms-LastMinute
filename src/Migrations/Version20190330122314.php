<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190330122314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chapters (id INT AUTO_INCREMENT NOT NULL, subject_id INT NOT NULL, chapter_name VARCHAR(20) NOT NULL, INDEX IDX_C721437123EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C721437123EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D523EDC87');
        $this->addSql('DROP INDEX IDX_8ADC54D523EDC87 ON questions');
        $this->addSql('ALTER TABLE questions CHANGE subject_id chapter_id INT NOT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5579F4768 FOREIGN KEY (chapter_id) REFERENCES chapters (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5579F4768 ON questions (chapter_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5579F4768');
        $this->addSql('DROP TABLE chapters');
        $this->addSql('DROP INDEX IDX_8ADC54D5579F4768 ON questions');
        $this->addSql('ALTER TABLE questions CHANGE chapter_id subject_id INT NOT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D523EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D523EDC87 ON questions (subject_id)');
    }
}
