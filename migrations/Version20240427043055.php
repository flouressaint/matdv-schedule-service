<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427043055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE study_group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_role_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_user_role DROP CONSTRAINT fk_2d084b47a76ed395');
        $this->addSql('ALTER TABLE user_user_role DROP CONSTRAINT fk_2d084b478e0e3ca6');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT fk_f87474f341807e1d');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT fk_f87474f35dddccce');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT fk_f87474f33cf19aa0');
        $this->addSql('ALTER TABLE user_study_group DROP CONSTRAINT fk_9ba1ddb0a76ed395');
        $this->addSql('ALTER TABLE user_study_group DROP CONSTRAINT fk_9ba1ddb05dddccce');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE user_user_role');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE study_group');
        $this->addSql('DROP TABLE user_study_group');
        $this->addSql('ALTER TABLE "user" ADD username VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP login');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE study_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_user_role (user_id INT NOT NULL, user_role_id INT NOT NULL, PRIMARY KEY(user_id, user_role_id))');
        $this->addSql('CREATE INDEX idx_2d084b478e0e3ca6 ON user_user_role (user_role_id)');
        $this->addSql('CREATE INDEX idx_2d084b47a76ed395 ON user_user_role (user_id)');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, teacher_id INT NOT NULL, study_group_id INT NOT NULL, auditorium_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f87474f33cf19aa0 ON lesson (auditorium_id)');
        $this->addSql('CREATE INDEX idx_f87474f35dddccce ON lesson (study_group_id)');
        $this->addSql('CREATE INDEX idx_f87474f341807e1d ON lesson (teacher_id)');
        $this->addSql('CREATE TABLE study_group (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_study_group (user_id INT NOT NULL, study_group_id INT NOT NULL, PRIMARY KEY(user_id, study_group_id))');
        $this->addSql('CREATE INDEX idx_9ba1ddb05dddccce ON user_study_group (study_group_id)');
        $this->addSql('CREATE INDEX idx_9ba1ddb0a76ed395 ON user_study_group (user_id)');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT fk_2d084b47a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT fk_2d084b478e0e3ca6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT fk_f87474f341807e1d FOREIGN KEY (teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT fk_f87474f35dddccce FOREIGN KEY (study_group_id) REFERENCES study_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT fk_f87474f33cf19aa0 FOREIGN KEY (auditorium_id) REFERENCES auditorium (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_study_group ADD CONSTRAINT fk_9ba1ddb0a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_study_group ADD CONSTRAINT fk_9ba1ddb05dddccce FOREIGN KEY (study_group_id) REFERENCES study_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_USERNAME');
        $this->addSql('ALTER TABLE "user" ADD login VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP username');
        $this->addSql('ALTER TABLE "user" DROP roles');
    }
}
