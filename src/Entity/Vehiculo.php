<?php

namespace App\Entity;

use App\Repository\VehiculoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculoRepository::class)]
class Vehiculo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\Column(length: 20)]
    private ?string $patente = null;

    #[ORM\Column(length: 50)]
    private ?string $marca = null;

    #[ORM\Column(length: 50)]
    private ?string $modelo = null;

    #[ORM\Column]
    private ?int $anio = null;

    /**
     * @var Collection<int, DetalleSiniestro>
     */
    #[ORM\OneToMany(targetEntity: DetalleSiniestro::class, mappedBy: 'vehiculo')]
    private Collection $detalleSiniestros;

    /**
     * @var Collection<int, VehiculoSiniestro>
     */
    #[ORM\OneToMany(targetEntity: VehiculoSiniestro::class, mappedBy: 'vehiculo')]
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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getPatente(): ?string
    {
        return $this->patente;
    }

    public function setPatente(string $patente): static
    {
        $this->patente = $patente;

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): static
    {
        $this->marca = $marca;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): static
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): static
    {
        $this->anio = $anio;

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
            $detalleSiniestro->setVehiculo($this);
        }

        return $this;
    }

    public function removeDetalleSiniestro(DetalleSiniestro $detalleSiniestro): static
    {
        if ($this->detalleSiniestros->removeElement($detalleSiniestro)) {
            // set the owning side to null (unless already changed)
            if ($detalleSiniestro->getVehiculo() === $this) {
                $detalleSiniestro->setVehiculo(null);
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
            $vehiculoSiniestro->setVehiculo($this);
        }

        return $this;
    }

    public function removeVehiculoSiniestro(VehiculoSiniestro $vehiculoSiniestro): static
    {
        if ($this->vehiculoSiniestros->removeElement($vehiculoSiniestro)) {
            // set the owning side to null (unless already changed)
            if ($vehiculoSiniestro->getVehiculo() === $this) {
                $vehiculoSiniestro->setVehiculo(null);
            }
        }

        return $this;
    }
}
