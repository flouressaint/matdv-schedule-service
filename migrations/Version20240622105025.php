<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622105025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE discipline_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE score_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE score (id INT NOT NULL, lesson_id INT NOT NULL, student_id INT NOT NULL, value INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32993751CDF80196 ON score (lesson_id)');
        $this->addSql('CREATE INDEX IDX_32993751CB944F1A ON score (student_id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751CB944F1A FOREIGN KEY (student_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41BE81705E237E06 ON auditorium (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32BA14255E237E06 ON study_group (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE score_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE discipline_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE discipline (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_75beee3f5e237e06 ON discipline (name)');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_32993751CDF80196');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_32993751CB944F1A');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP INDEX UNIQ_32BA14255E237E06');
        $this->addSql('DROP INDEX UNIQ_41BE81705E237E06');
    }
}
