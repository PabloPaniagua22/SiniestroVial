<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $apellido = null;

    #[ORM\Column(length: 20)]
    private ?string $dni = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fechaNacimiento = null;

    #[ORM\Column(length: 255)]
    private ?string $genero = null;

    #[ORM\Column(length: 50)]
    private ?string $estadoCivil = null;

    /**
     * @var Collection<int, DetalleSiniestro>
     */
    #[ORM\OneToMany(targetEntity: DetalleSiniestro::class, mappedBy: 'persona')]
    private Collection $detalleSiniestros;

    /**
     * @var Collection<int, VehiculoSiniestro>
     */
    #[ORM\OneToMany(targetEntity: VehiculoSiniestro::class, mappedBy: 'persona')]
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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTime
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTime $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getEstadoCivil(): ?string
    {
        return $this->estadoCivil;
    }

    public function setEstadoCivil(string $estadoCivil): static
    {
        $this->estadoCivil = $estadoCivil;

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
            $detalleSiniestro->setPersona($this);
        }

        return $this;
    }

    public function removeDetalleSiniestro(DetalleSiniestro $detalleSiniestro): static
    {
        if ($this->detalleSiniestros->removeElement($detalleSiniestro)) {
            // set the owning side to null (unless already changed)
            if ($detalleSiniestro->getPersona() === $this) {
                $detalleSiniestro->setPersona(null);
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
            $vehiculoSiniestro->setPersona($this);
        }

        return $this;
    }

    public function removeVehiculoSiniestro(VehiculoSiniestro $vehiculoSiniestro): static
    {
        if ($this->vehiculoSiniestros->removeElement($vehiculoSiniestro)) {
            // set the owning side to null (unless already changed)
            if ($vehiculoSiniestro->getPersona() === $this) {
                $vehiculoSiniestro->setPersona(null);
            }
        }

        return $this;
    }
}
