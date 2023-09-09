<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ApartadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApartadoRepository::class)]
#[ApiResource]
class Apartado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tituloApartado = null;

    #[ORM\Column(length: 1200)]
    private ?string $contenidoApartado = null;

    #[ORM\ManyToOne(inversedBy: 'apartados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seccion $fkSeccion = null;

    #[ORM\OneToMany(mappedBy: 'fkApartado', targetEntity: Subapartado::class)]
    private Collection $subapartados;

    #[ORM\OneToMany(mappedBy: 'fkApartado', targetEntity: Cita::class)]
    private Collection $citas;

    #[ORM\OneToMany(mappedBy: 'fkApartado', targetEntity: Audiovisual::class)]
    private Collection $audiovisuals;

    public function __construct()
    {
        $this->subapartados = new ArrayCollection();
        $this->citas = new ArrayCollection();
        $this->audiovisuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTituloApartado(): ?string
    {
        return $this->tituloApartado;
    }

    public function setTituloApartado(string $tituloApartado): static
    {
        $this->tituloApartado = $tituloApartado;

        return $this;
    }

    public function getContenidoApartado(): ?string
    {
        return $this->contenidoApartado;
    }

    public function setContenidoApartado(string $contenidoApartado): static
    {
        $this->contenidoApartado = $contenidoApartado;

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

    /**
     * @return Collection<int, Subapartado>
     */
    public function getSubapartados(): Collection
    {
        return $this->subapartados;
    }

    public function addSubapartado(Subapartado $subapartado): static
    {
        if (!$this->subapartados->contains($subapartado)) {
            $this->subapartados->add($subapartado);
            $subapartado->setFkApartado($this);
        }

        return $this;
    }

    public function removeSubapartado(Subapartado $subapartado): static
    {
        if ($this->subapartados->removeElement($subapartado)) {
            // set the owning side to null (unless already changed)
            if ($subapartado->getFkApartado() === $this) {
                $subapartado->setFkApartado(null);
            }
        }

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
            $cita->setFkApartado($this);
        }

        return $this;
    }

    public function removeCita(Cita $cita): static
    {
        if ($this->citas->removeElement($cita)) {
            // set the owning side to null (unless already changed)
            if ($cita->getFkApartado() === $this) {
                $cita->setFkApartado(null);
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
            $audiovisual->setFkApartado($this);
        }

        return $this;
    }

    public function removeAudiovisual(Audiovisual $audiovisual): static
    {
        if ($this->audiovisuals->removeElement($audiovisual)) {
            // set the owning side to null (unless already changed)
            if ($audiovisual->getFkApartado() === $this) {
                $audiovisual->setFkApartado(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId(); 
    }
}
