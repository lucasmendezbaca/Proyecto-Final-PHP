<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306174930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nif INT NOT NULL, nombre_fiscal VARCHAR(64) NOT NULL, nombre_comercial VARCHAR(64) NOT NULL, domicilio VARCHAR(64) NOT NULL, codigo_postal INT NOT NULL, provincia VARCHAR(64) NOT NULL, poblacion VARCHAR(64) NOT NULL, pais VARCHAR(64) NOT NULL, telefono INT NOT NULL, email VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cliente');
    }
}
