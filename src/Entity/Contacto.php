<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContactoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactoRepository::class)]
#[ApiResource]
class Contacto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreContacto = null;

    #[ORM\Column(length: 255)]
    private ?string $consultaContacto = null;

    #[ORM\Column(length: 255)]
    private ?string $emailContacto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreContacto(): ?string
    {
        return $this->nombreContacto;
    }

    public function setNombreContacto(string $nombreContacto): static
    {
        $this->nombreContacto = $nombreContacto;

        return $this;
    }

    public function getConsultaContacto(): ?string
    {
        return $this->consultaContacto;
    }

    public function setConsultaContacto(string $consultaContacto): static
    {
        $this->consultaContacto = $consultaContacto;

        return $this;
    }

    public function getEmailContacto(): ?string
    {
        return $this->emailContacto;
    }

    public function setEmailContacto(string $emailContacto): static
    {
        $this->emailContacto = $emailContacto;

        return $this;
    }
}
