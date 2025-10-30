<?php

namespace App\Entity;

use App\Repository\SiniestroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiniestroRepository::class)]
class Siniestro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $hora = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $severidad = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(length: 100)]
    private ?string $localidad = null;

    #[ORM\Column(length: 150)]
    private ?string $calle = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $coordenadas = null;

    #[ORM\Column(length: 50)]
    private ?string $nroActa = null;

    #[ORM\ManyToOne(inversedBy: 'siniestros')]
    private ?Usuario $Usuario = null;

    /**
     * @var Collection<int, DetalleSiniestro>
     */
    #[ORM\OneToMany(targetEntity: DetalleSiniestro::class, mappedBy: 'siniestro')]
    private Collection $detalleSiniestros;

    /**
     * @var Collection<int, VehiculoSiniestro>
     */
    #[ORM\OneToMany(targetEntity: VehiculoSiniestro::class, mappedBy: 'siniestro')]
    private Collection $vehiculoSiniestros;

    public function __construct()
    {
        $this->detalleSiniestros = new ArrayCollection();
        $this->vehiculoSiniestros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTime
    {
        return $this->hora;
    }

    public function setHora(\DateTime $hora): static
    {
        $this->hora = $hora;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getSeveridad(): ?string
    {
        return $this->severidad;
    }

    public function setSeveridad(string $severidad): static
    {
        $this->severidad = $severidad;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): static
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): static
    {
        $this->calle = $calle;

        return $this;
    }

    public function getCoordenadas(): ?string
    {
        return $this->coordenadas;
    }

    public function setCoordenadas(?string $coordenadas): static
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    public function getNroActa(): ?string
    {
        return $this->nroActa;
    }

    public function setNroActa(string $nroActa): static
    {
        $this->nroActa = $nroActa;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->Usuario;
    }

    public function setUsuario(?Usuario $Usuario): static
    {
        $this->Usuario = $Usuario;

        return $this;
    }

    /**
     * @return Collection<int, DetalleSiniestro>
     */
    public function getDetalleSiniestros(): Collection
    {
        return $this->detalleSiniestros;
    }

    public function addDetalleSiniestro(DetalleSiniestro $detalleSiniestro): static
    {
        if (!$this->detalleSiniestros->contains($detalleSiniestro)) {
            $this->detalleSiniestros->add($detalleSiniestro);
            $detalleSiniestro->setSiniestro($this);
        }

        return $this;
    }

    public function removeDetalleSiniestro(DetalleSiniestro $detalleSiniestro): static
    {
        if ($this->detalleSiniestros->removeElement($detalleSiniestro)) {
            // set the owning side to null (unless already changed)
            if ($detalleSiniestro->getSiniestro() === $this) {
                $detalleSiniestro->setSiniestro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VehiculoSiniestro>
     */
    public function getVehiculoSiniestros(): Collection
    {
        return $this->vehiculoSiniestros;
    }

    public function addVehiculoSiniestro(VehiculoSiniestro $vehiculoSiniestro): static
    {
        if (!$this->vehiculoSiniestros->contains($vehiculoSiniestro)) {
            $this->vehiculoSiniestros->add($vehiculoSiniestro);
            $vehiculoSiniestro->setSiniestro($this);
        }

        return $this;
    }

    public function removeVehiculoSiniestro(VehiculoSiniestro $vehiculoSiniestro): static
    {
        if ($this->vehiculoSiniestros->removeElement($vehiculoSiniestro)) {
            // set the owning side to null (unless already changed)
            if ($vehiculoSiniestro->getSiniestro() === $this) {
                $vehiculoSiniestro->setSiniestro(null);
            }
        }

        return $this;
    }
}
