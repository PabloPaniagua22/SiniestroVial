<?php

namespace App\Entity;

use App\Repository\VehiculoSiniestroRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculoSiniestroRepository::class)]
class VehiculoSiniestro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vehiculoSiniestros')]
    private ?Siniestro $siniestro = null;

    #[ORM\ManyToOne(inversedBy: 'vehiculoSiniestros')]
    private ?Vehiculo $vehiculo = null;

    #[ORM\ManyToOne(inversedBy: 'vehiculoSiniestros')]
    private ?Persona $persona = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiniestro(): ?Siniestro
    {
        return $this->siniestro;
    }

    public function setSiniestro(?Siniestro $siniestro): static
    {
        $this->siniestro = $siniestro;

        return $this;
    }

    public function getVehiculo(): ?Vehiculo
    {
        return $this->vehiculo;
    }

    public function setVehiculo(?Vehiculo $vehiculo): static
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): static
    {
        $this->persona = $persona;

        return $this;
    }
}
