<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AudiovisualRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudiovisualRepository::class)]
#[ApiResource]
class Audiovisual
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $rutaAudiovisual = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $pieAudiovisual = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoPadre = null;

    #[ORM\ManyToOne(inversedBy: 'audiovisuals')]
    private ?Seccion $fkSeccion = null;

    #[ORM\ManyToOne(inversedBy: 'audiovisuals')]
    private ?Apartado $fkApartado = null;

    #[ORM\ManyToOne(inversedBy: 'audiovisuals')]
    private ?Subapartado $fkSubapartado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRutaAudiovisual(): ?string
    {
        return $this->rutaAudiovisual;
    }

    public function setRutaAudiovisual(string $rutaAudiovisual): static
    {
        $this->rutaAudiovisual = $rutaAudiovisual;

        return $this;
    }

    public function getPieAudiovisual(): ?string
    {
        return $this->pieAudiovisual;
    }

    public function setPieAudiovisual(?string $pieAudiovisual): static
    {
        $this->pieAudiovisual = $pieAudiovisual;

        return $this;
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
