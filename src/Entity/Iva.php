<?php

namespace App\Entity;

use App\Repository\IvaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IvaRepository::class)]
class Iva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $porcentaje = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPorcentaje(): ?int
    {
        return $this->porcentaje;
    }

    public function setPorcentaje(int $porcentaje): self
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }
}
