<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430031721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE study_group_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE study_group_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE study_group ADD study_group_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE study_group ADD CONSTRAINT FK_32BA14254B55C719 FOREIGN KEY (study_group_category_id) REFERENCES study_group_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_32BA14254B55C719 ON study_group (study_group_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE study_group DROP CONSTRAINT FK_32BA14254B55C719');
        $this->addSql('DROP SEQUENCE study_group_category_id_seq CASCADE');
        $this->addSql('DROP TABLE study_group_category');
        $this->addSql('DROP INDEX IDX_32BA14254B55C719');
        $this->addSql('ALTER TABLE study_group DROP study_group_category_id');
    }
}
