<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SeccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeccionRepository::class)]
#[ApiResource]
class Seccion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tituloSeccion = null;

    #[ORM\OneToMany(mappedBy: 'fkSeccion', targetEntity: Apartado::class)]
    private Collection $apartados;

    #[ORM\OneToMany(mappedBy: 'fkSeccion', targetEntity: Cita::class)]
    private Collection $citas;

    #[ORM\OneToMany(mappedBy: 'fkSeccion', targetEntity: Audiovisual::class)]
    private Collection $audiovisuals;

    public function __construct()
    {
        $this->apartados = new ArrayCollection();
        $this->citas = new ArrayCollection();
        $this->audiovisuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTituloSeccion(): ?string
    {
        return $this->tituloSeccion;
    }

    public function setTituloSeccion(string $tituloSeccion): static
    {
        $this->tituloSeccion = $tituloSeccion;

        return $this;
    }

    /**
     * @return Collection<int, Apartado>
     */
    public function getApartados(): Collection
    {
        return $this->apartados;
    }

    public function addApartado(Apartado $apartado): static
    {
        if (!$this->apartados->contains($apartado)) {
            $this->apartados->add($apartado);
            $apartado->setFkSeccion($this);
        }

        return $this;
    }

    public function removeApartado(Apartado $apartado): static
    {
        if ($this->apartados->removeElement($apartado)) {
            // set the owning side to null (unless already changed)
            if ($apartado->getFkSeccion() === $this) {
                $apartado->setFkSeccion(null);
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
            $cita->setFkSeccion($this);
        }

        return $this;
    }

    public function removeCita(Cita $cita): static
    {
        if ($this->citas->removeElement($cita)) {
            // set the owning side to null (unless already changed)
            if ($cita->getFkSeccion() === $this) {
                $cita->setFkSeccion(null);
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
            $audiovisual->setFkSeccion($this);
        }

        return $this;
    }

    public function removeAudiovisual(Audiovisual $audiovisual): static
    {
        if ($this->audiovisuals->removeElement($audiovisual)) {
            // set the owning side to null (unless already changed)
            if ($audiovisual->getFkSeccion() === $this) {
                $audiovisual->setFkSeccion(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId(); 
    }

}
