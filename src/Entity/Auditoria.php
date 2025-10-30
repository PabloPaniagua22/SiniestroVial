<?php

namespace App\Entity;

use App\Repository\AuditoriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditoriaRepository::class)]
class Auditoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'auditorias')]
    private ?Usuario $usuario = null;

    #[ORM\Column(length: 100)]
    private ?string $accion = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $entidadAfectada = null;

    #[ORM\Column]
    private ?\DateTime $fechaHora = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getAccion(): ?string
    {
        return $this->accion;
    }

    public function setAccion(string $accion): static
    {
        $this->accion = $accion;

        return $this;
    }

    public function getEntidadAfectada(): ?string
    {
        return $this->entidadAfectada;
    }

    public function setEntidadAfectada(?string $entidadAfectada): static
    {
        $this->entidadAfectada = $entidadAfectada;

        return $this;
    }

    public function getFechaHora(): ?\DateTime
    {
        return $this->fechaHora;
    }

    public function setFechaHora(\DateTime $fechaHora): static
    {
        $this->fechaHora = $fechaHora;

        return $this;
    }
}
