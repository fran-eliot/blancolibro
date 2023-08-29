<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CitaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitaRepository::class)]
#[ApiResource]
class Cita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoPadre = null;

    #[ORM\Column(length: 1200)]
    private ?string $contenidoCita = null;

    #[ORM\ManyToOne(inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Seccion $fkSeccion = null;

    #[ORM\ManyToOne(inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Apartado $fkApartado = null;

    #[ORM\ManyToOne(inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Subapartado $fkSubapartado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoPadre(): ?string
    {
        return $this->tipoPadre;
    }

    public function setTipoPadre(string $tipoPadre): static
    {
        $this->tipoPadre = $tipoPadre;

        return $this;
    }

    public function getContenidoCita(): ?string
    {
        return $this->contenidoCita;
    }

    public function setContenidoCita(string $contenidoCita): static
    {
        $this->contenidoCita = $contenidoCita;

        return $this;
    }

    public function getFkSeccion(): ?Seccion
    {
        return $this->fkSeccion;
    }

    public function setFkSeccion(?Seccion $fkSeccion): static
    {
        $this->fkSeccion = $fkSeccion;

        return $this;
    }

    public function getFkApartado(): ?Apartado
    {
        return $this->fkApartado;
    }

    public function setFkApartado(?Apartado $fkApartado): static
    {
        $this->fkApartado = $fkApartado;

        return $this;
    }

    public function getFkSubapartado(): ?Subapartado
    {
        return $this->fkSubapartado;
    }

    public function setFkSubapartado(?Subapartado $fkSubapartado): static
    {
        $this->fkSubapartado = $fkSubapartado;

        return $this;
    }
}
