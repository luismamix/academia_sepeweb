<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922160323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE curso (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, duracion INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudiante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, apellido1 VARCHAR(255) DEFAULT NULL, apellido2 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nota (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT DEFAULT NULL, curso_id INT DEFAULT NULL, nota DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C8D03E0D59590C39 (estudiante_id), INDEX IDX_C8D03E0D87CB4A1F (curso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nota ADD CONSTRAINT FK_C8D03E0D59590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)');
        $this->addSql('ALTER TABLE nota ADD CONSTRAINT FK_C8D03E0D87CB4A1F FOREIGN KEY (curso_id) REFERENCES curso (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nota DROP FOREIGN KEY FK_C8D03E0D87CB4A1F');
        $this->addSql('ALTER TABLE nota DROP FOREIGN KEY FK_C8D03E0D59590C39');
        $this->addSql('DROP TABLE curso');
        $this->addSql('DROP TABLE estudiante');
        $this->addSql('DROP TABLE nota');
    }
}
