<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502061700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, auditorium_id INT NOT NULL, study_group_id INT NOT NULL, hometask_id INT DEFAULT NULL, date DATE NOT NULL, start_time TIME(0) WITHOUT TIME ZONE NOT NULL, end_time TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F87474F33CF19AA0 ON lesson (auditorium_id)');
        $this->addSql('CREATE INDEX IDX_F87474F35DDDCCCE ON lesson (study_group_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F87474F384818FB8 ON lesson (hometask_id)');
        $this->addSql('COMMENT ON COLUMN lesson.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN lesson.start_time IS \'(DC2Type:time_immutable)\'');
        $this->addSql('COMMENT ON COLUMN lesson.end_time IS \'(DC2Type:time_immutable)\'');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F33CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditorium (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F35DDDCCCE FOREIGN KEY (study_group_id) REFERENCES study_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F384818FB8 FOREIGN KEY (hometask_id) REFERENCES hometask (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F33CF19AA0');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F35DDDCCCE');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F384818FB8');
        $this->addSql('DROP TABLE lesson');
    }
}
