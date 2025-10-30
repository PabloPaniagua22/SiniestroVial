<?php

namespace App\Entity;

use App\Repository\DetalleSiniestroRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleSiniestroRepository::class)]
class DetalleSiniestro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detalleSiniestros')]
    private ?Siniestro $siniestro = null;

    #[ORM\ManyToOne(inversedBy: 'detalleSiniestros')]
    private ?Persona $persona = null;

    #[ORM\ManyToOne(inversedBy: 'detalleSiniestros')]
    private ?RolPersona $rolPersona = null;

    #[ORM\ManyToOne(inversedBy: 'detalleSiniestros')]
    private ?Vehiculo $vehiculo = null;

    #[ORM\Column(length: 255)]
    private ?string $estadoAlcoholico = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $porcentajeAlcohol = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rutaDocumento = null;

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

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): static
    {
        $this->persona = $persona;

        return $this;
    }

    public function getRolPersona(): ?RolPersona
    {
        return $this->rolPersona;
    }

    public function setRolPersona(?RolPersona $rolPersona): static
    {
        $this->rolPersona = $rolPersona;

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

    public function getEstadoAlcoholico(): ?string
    {
        return $this->estadoAlcoholico;
    }

    public function setEstadoAlcoholico(string $estadoAlcoholico): static
    {
        $this->estadoAlcoholico = $estadoAlcoholico;

        return $this;
    }

    public function getPorcentajeAlcohol(): ?string
    {
        return $this->porcentajeAlcohol;
    }

    public function setPorcentajeAlcohol(?string $porcentajeAlcohol): static
    {
        $this->porcentajeAlcohol = $porcentajeAlcohol;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getRutaDocumento(): ?string
    {
        return $this->rutaDocumento;
    }

    public function setRutaDocumento(?string $rutaDocumento): static
    {
        $this->rutaDocumento = $rutaDocumento;

        return $this;
    }
}
