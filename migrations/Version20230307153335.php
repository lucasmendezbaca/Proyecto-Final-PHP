<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307153335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_factura ADD factura_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE linea_factura ADD CONSTRAINT FK_B8330A4EF04F795F FOREIGN KEY (factura_id) REFERENCES factura (id)');
        $this->addSql('CREATE INDEX IDX_B8330A4EF04F795F ON linea_factura (factura_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_factura DROP FOREIGN KEY FK_B8330A4EF04F795F');
        $this->addSql('DROP INDEX IDX_B8330A4EF04F795F ON linea_factura');
        $this->addSql('ALTER TABLE linea_factura DROP factura_id');
    }
}
