<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SubapartadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubapartadoRepository::class)]
#[ApiResource]
class Subapartado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tituloSubapartado = null;

    #[ORM\Column(length: 1200)]
    private ?string $contenidoSubapartado = null;

    #[ORM\ManyToOne(inversedBy: 'subapartados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Apartado $fkApartado = null;

    #[ORM\OneToMany(mappedBy: 'fkSubapartado', targetEntity: Cita::class)]
    private Collection $citas;

    #[ORM\OneToMany(mappedBy: 'fkSubapartado', targetEntity: Audiovisual::class)]
    private Collection $audiovisuals;

    public function __construct()
    {
        $this->citas = new ArrayCollection();
        $this->audiovisuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTituloSubapartado(): ?string
    {
        return $this->tituloSubapartado;
    }

    public function setTituloSubapartado(string $tituloSubapartado): static
    {
        $this->tituloSubapartado = $tituloSubapartado;

        return $this;
    }

    public function getContenidoSubapartado(): ?string
    {
        return $this->contenidoSubapartado;
    }

    public function setContenidoSubapartado(string $contenidoSubapartado): static
    {
        $this->contenidoSubapartado = $contenidoSubapartado;

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

    /**
     * @return Collection<int, Cita>
     */
    public function getCitas(): Collection
    {
        return $this->citas;
    }

    public function addCita(Cita $cita): static
    {
        if (!$this->citas->contains($cita)) {
            $this->citas->add($cita);
            $cita->setFkSubapartado($this);
        }

        return $this;
    }

    public function removeCita(Cita $cita): static
    {
        if ($this->citas->removeElement($cita)) {
            // set the owning side to null (unless already changed)
            if ($cita->getFkSubapartado() === $this) {
                $cita->setFkSubapartado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Audiovisual>
     */
    public function getAudiovisuals(): Collection
    {
        return $this->audiovisuals;
    }

    public function addAudiovisual(Audiovisual $audiovisual): static
    {
        if (!$this->audiovisuals->contains($audiovisual)) {
            $this->audiovisuals->add($audiovisual);
            $audiovisual->setFkSubapartado($this);
        }

        return $this;
    }

    public function removeAudiovisual(Audiovisual $audiovisual): static
    {
        if ($this->audiovisuals->removeElement($audiovisual)) {
            // set the owning side to null (unless already changed)
            if ($audiovisual->getFkSubapartado() === $this) {
                $audiovisual->setFkSubapartado(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId(); 
    }
}
