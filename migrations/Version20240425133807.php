<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425133807 extends AbstractMigration
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
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE study_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auditorium (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE discipline (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3F5E237E06 ON discipline (name)');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, teacher_id INT NOT NULL, study_group_id INT NOT NULL, auditorium_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F87474F341807E1D ON lesson (teacher_id)');
        $this->addSql('CREATE INDEX IDX_F87474F35DDDCCCE ON lesson (study_group_id)');
        $this->addSql('CREATE INDEX IDX_F87474F33CF19AA0 ON lesson (auditorium_id)');
        $this->addSql('CREATE TABLE study_group (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, full_name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_user_role (user_id INT NOT NULL, user_role_id INT NOT NULL, PRIMARY KEY(user_id, user_role_id))');
        $this->addSql('CREATE INDEX IDX_2D084B47A76ED395 ON user_user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2D084B478E0E3CA6 ON user_user_role (user_role_id)');
        $this->addSql('CREATE TABLE user_study_group (user_id INT NOT NULL, study_group_id INT NOT NULL, PRIMARY KEY(user_id, study_group_id))');
        $this->addSql('CREATE INDEX IDX_9BA1DDB0A76ED395 ON user_study_group (user_id)');
        $this->addSql('CREATE INDEX IDX_9BA1DDB05DDDCCCE ON user_study_group (study_group_id)');
        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F35DDDCCCE FOREIGN KEY (study_group_id) REFERENCES study_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F33CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditorium (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B47A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B478E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_study_group ADD CONSTRAINT FK_9BA1DDB0A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_study_group ADD CONSTRAINT FK_9BA1DDB05DDDCCCE FOREIGN KEY (study_group_id) REFERENCES study_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE auditorium_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE discipline_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE study_group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_role_id_seq CASCADE');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F35DDDCCCE');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F33CF19AA0');
        $this->addSql('ALTER TABLE user_user_role DROP CONSTRAINT FK_2D084B47A76ED395');
        $this->addSql('ALTER TABLE user_user_role DROP CONSTRAINT FK_2D084B478E0E3CA6');
        $this->addSql('ALTER TABLE user_study_group DROP CONSTRAINT FK_9BA1DDB0A76ED395');
        $this->addSql('ALTER TABLE user_study_group DROP CONSTRAINT FK_9BA1DDB05DDDCCCE');
        $this->addSql('DROP TABLE auditorium');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE study_group');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_user_role');
        $this->addSql('DROP TABLE user_study_group');
        $this->addSql('DROP TABLE user_role');
    }
}
