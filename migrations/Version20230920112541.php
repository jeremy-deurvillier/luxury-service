<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920112541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, job_category_id INT DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(2) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, place_of_birth VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, passport_file VARCHAR(255) DEFAULT NULL, avatar_file VARCHAR(255) DEFAULT NULL, cv_file VARCHAR(255) DEFAULT NULL, experience VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, notes LONGTEXT DEFAULT NULL, email_confirmed TINYINT(1) NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_C8B28E44712A86AB (job_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_phone VARCHAR(255) NOT NULL, contact_job VARCHAR(255) NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_job_category (client_id INT NOT NULL, job_category_id INT NOT NULL, INDEX IDX_D0011EBB19EB6921 (client_id), INDEX IDX_D0011EBB712A86AB (job_category_id), PRIMARY KEY(client_id, job_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, job_category_id INT NOT NULL, clients_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, job VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, salary INT DEFAULT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', closing_date DATE DEFAULT NULL, INDEX IDX_288A3A4E712A86AB (job_category_id), INDEX IDX_288A3A4EAB014612 (clients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44712A86AB FOREIGN KEY (job_category_id) REFERENCES job_category (id)');
        $this->addSql('ALTER TABLE client_job_category ADD CONSTRAINT FK_D0011EBB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_job_category ADD CONSTRAINT FK_D0011EBB712A86AB FOREIGN KEY (job_category_id) REFERENCES job_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E712A86AB FOREIGN KEY (job_category_id) REFERENCES job_category (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4EAB014612 FOREIGN KEY (clients_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user ADD candidate_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE name nickname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64991BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64991BD8781 ON user (candidate_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64991BD8781');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44712A86AB');
        $this->addSql('ALTER TABLE client_job_category DROP FOREIGN KEY FK_D0011EBB19EB6921');
        $this->addSql('ALTER TABLE client_job_category DROP FOREIGN KEY FK_D0011EBB712A86AB');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E712A86AB');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4EAB014612');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_job_category');
        $this->addSql('DROP TABLE job_category');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('DROP INDEX UNIQ_8D93D64991BD8781 ON user');
        $this->addSql('ALTER TABLE user DROP candidate_id, DROP created_at, DROP updated_at, DROP deleted_at, CHANGE nickname name VARCHAR(255) NOT NULL');
    }
}
