<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429100519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE auditorium_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE discipline_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hometask_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE refresh_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE study_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auditorium (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE discipline (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3F5E237E06 ON discipline (name)');
        $this->addSql('CREATE TABLE hometask (id INT NOT NULL, description TEXT NOT NULL, attachment VARCHAR(700) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE refresh_token (id INT NOT NULL, user_id INT NOT NULL, refresh_token VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C74F2195A76ED395 ON refresh_token (user_id)');
        $this->addSql('COMMENT ON COLUMN refresh_token.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE study_group (id INT NOT NULL, teacher_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32BA142541807E1D ON study_group (teacher_id)');
        $this->addSql('CREATE TABLE study_group_user (study_group_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(study_group_id, user_id))');
        $this->addSql('CREATE INDEX IDX_2355E9595DDDCCCE ON study_group_user (study_group_id)');
        $this->addSql('CREATE INDEX IDX_2355E959A76ED395 ON study_group_user (user_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, full_name VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F2195A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE study_group ADD CONSTRAINT FK_32BA142541807E1D FOREIGN KEY (teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE study_group_user ADD CONSTRAINT FK_2355E9595DDDCCCE FOREIGN KEY (study_group_id) REFERENCES study_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE study_group_user ADD CONSTRAINT FK_2355E959A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE auditorium_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE discipline_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hometask_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE refresh_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE study_group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE refresh_token DROP CONSTRAINT FK_C74F2195A76ED395');
        $this->addSql('ALTER TABLE study_group DROP CONSTRAINT FK_32BA142541807E1D');
        $this->addSql('ALTER TABLE study_group_user DROP CONSTRAINT FK_2355E9595DDDCCCE');
        $this->addSql('ALTER TABLE study_group_user DROP CONSTRAINT FK_2355E959A76ED395');
        $this->addSql('DROP TABLE auditorium');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE hometask');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE study_group');
        $this->addSql('DROP TABLE study_group_user');
        $this->addSql('DROP TABLE "user"');
    }
}
