<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $apellido = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $contrasena = null;

    #[ORM\Column(length: 255)]
    private ?string $rol = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    /**
     * @var Collection<int, Siniestro>
     */
    #[ORM\OneToMany(targetEntity: Siniestro::class, mappedBy: 'Usuario')]
    private Collection $siniestros;

    /**
     * @var Collection<int, Auditoria>
     */
    #[ORM\OneToMany(targetEntity: Auditoria::class, mappedBy: 'usuario')]
    private Collection $auditorias;

    public function __construct()
    {
        $this->siniestros = new ArrayCollection();
        $this->auditorias = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getContrasena(): ?string
    {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): static
    {
        $this->contrasena = $contrasena;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): static
    {
        $this->rol = $rol;

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

    /**
     * @return Collection<int, Siniestro>
     */
    public function getSiniestros(): Collection
    {
        return $this->siniestros;
    }

    public function addSiniestro(Siniestro $siniestro): static
    {
        if (!$this->siniestros->contains($siniestro)) {
            $this->siniestros->add($siniestro);
            $siniestro->setUsuario($this);
        }

        return $this;
    }

    public function removeSiniestro(Siniestro $siniestro): static
    {
        if ($this->siniestros->removeElement($siniestro)) {
            // set the owning side to null (unless already changed)
            if ($siniestro->getUsuario() === $this) {
                $siniestro->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Auditoria>
     */
    public function getAuditorias(): Collection
    {
        return $this->auditorias;
    }

    public function addAuditoria(Auditoria $auditoria): static
    {
        if (!$this->auditorias->contains($auditoria)) {
            $this->auditorias->add($auditoria);
            $auditoria->setUsuario($this);
        }

        return $this;
    }

    public function removeAuditoria(Auditoria $auditoria): static
    {
        if ($this->auditorias->removeElement($auditoria)) {
            // set the owning side to null (unless already changed)
            if ($auditoria->getUsuario() === $this) {
                $auditoria->setUsuario(null);
            }
        }

        return $this;
    }
}
