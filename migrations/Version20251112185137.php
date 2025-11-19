<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251112185137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_siniestro DROP FOREIGN KEY FK_8E39D83AF5F88DB9');
        $this->addSql('ALTER TABLE detalle_siniestro ADD CONSTRAINT FK_8E39D83AF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_siniestro DROP FOREIGN KEY FK_8E39D83AF5F88DB9');
        $this->addSql('ALTER TABLE detalle_siniestro ADD CONSTRAINT FK_8E39D83AF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
