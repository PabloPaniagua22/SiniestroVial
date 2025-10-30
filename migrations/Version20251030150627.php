<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030150627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auditoria (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, accion VARCHAR(100) NOT NULL, entidad_afectada VARCHAR(100) DEFAULT NULL, fecha_hora DATETIME NOT NULL, INDEX IDX_AF4BB49DDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_siniestro (id INT AUTO_INCREMENT NOT NULL, siniestro_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, rol_persona_id INT DEFAULT NULL, vehiculo_id INT DEFAULT NULL, estado_alcoholico VARCHAR(255) NOT NULL, porcentaje_alcohol NUMERIC(4, 2) DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, ruta_documento VARCHAR(255) DEFAULT NULL, INDEX IDX_8E39D83A90195D8C (siniestro_id), INDEX IDX_8E39D83AF5F88DB9 (persona_id), INDEX IDX_8E39D83A2355ECE0 (rol_persona_id), INDEX IDX_8E39D83A25F7D575 (vehiculo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, apellido VARCHAR(100) NOT NULL, dni VARCHAR(20) NOT NULL, fecha_nacimiento DATE NOT NULL, genero VARCHAR(255) NOT NULL, estado_civil VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rol_persona (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE siniestro (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, descripcion LONGTEXT NOT NULL, severidad VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, localidad VARCHAR(100) NOT NULL, calle VARCHAR(150) NOT NULL, coordenadas VARCHAR(100) DEFAULT NULL, nro_acta VARCHAR(50) NOT NULL, INDEX IDX_AF55697ADB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehiculo (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, patente VARCHAR(20) NOT NULL, marca VARCHAR(50) NOT NULL, modelo VARCHAR(50) NOT NULL, anio INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehiculo_siniestro (id INT AUTO_INCREMENT NOT NULL, siniestro_id INT DEFAULT NULL, vehiculo_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, INDEX IDX_E10A9A4590195D8C (siniestro_id), INDEX IDX_E10A9A4525F7D575 (vehiculo_id), INDEX IDX_E10A9A45F5F88DB9 (persona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auditoria ADD CONSTRAINT FK_AF4BB49DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE detalle_siniestro ADD CONSTRAINT FK_8E39D83A90195D8C FOREIGN KEY (siniestro_id) REFERENCES siniestro (id)');
        $this->addSql('ALTER TABLE detalle_siniestro ADD CONSTRAINT FK_8E39D83AF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE detalle_siniestro ADD CONSTRAINT FK_8E39D83A2355ECE0 FOREIGN KEY (rol_persona_id) REFERENCES rol_persona (id)');
        $this->addSql('ALTER TABLE detalle_siniestro ADD CONSTRAINT FK_8E39D83A25F7D575 FOREIGN KEY (vehiculo_id) REFERENCES vehiculo (id)');
        $this->addSql('ALTER TABLE siniestro ADD CONSTRAINT FK_AF55697ADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE vehiculo_siniestro ADD CONSTRAINT FK_E10A9A4590195D8C FOREIGN KEY (siniestro_id) REFERENCES siniestro (id)');
        $this->addSql('ALTER TABLE vehiculo_siniestro ADD CONSTRAINT FK_E10A9A4525F7D575 FOREIGN KEY (vehiculo_id) REFERENCES vehiculo (id)');
        $this->addSql('ALTER TABLE vehiculo_siniestro ADD CONSTRAINT FK_E10A9A45F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auditoria DROP FOREIGN KEY FK_AF4BB49DDB38439E');
        $this->addSql('ALTER TABLE detalle_siniestro DROP FOREIGN KEY FK_8E39D83A90195D8C');
        $this->addSql('ALTER TABLE detalle_siniestro DROP FOREIGN KEY FK_8E39D83AF5F88DB9');
        $this->addSql('ALTER TABLE detalle_siniestro DROP FOREIGN KEY FK_8E39D83A2355ECE0');
        $this->addSql('ALTER TABLE detalle_siniestro DROP FOREIGN KEY FK_8E39D83A25F7D575');
        $this->addSql('ALTER TABLE siniestro DROP FOREIGN KEY FK_AF55697ADB38439E');
        $this->addSql('ALTER TABLE vehiculo_siniestro DROP FOREIGN KEY FK_E10A9A4590195D8C');
        $this->addSql('ALTER TABLE vehiculo_siniestro DROP FOREIGN KEY FK_E10A9A4525F7D575');
        $this->addSql('ALTER TABLE vehiculo_siniestro DROP FOREIGN KEY FK_E10A9A45F5F88DB9');
        $this->addSql('DROP TABLE auditoria');
        $this->addSql('DROP TABLE detalle_siniestro');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE rol_persona');
        $this->addSql('DROP TABLE siniestro');
        $this->addSql('DROP TABLE vehiculo');
        $this->addSql('DROP TABLE vehiculo_siniestro');
    }
}
