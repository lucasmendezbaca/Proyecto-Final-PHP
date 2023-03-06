<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nif = null;

    #[ORM\Column(length: 64)]
    private ?string $nombre_fiscal = null;

    #[ORM\Column(length: 64)]
    private ?string $nombre_comercial = null;

    #[ORM\Column(length: 64)]
    private ?string $domicilio = null;

    #[ORM\Column]
    private ?int $codigo_postal = null;

    #[ORM\Column(length: 64)]
    private ?string $provincia = null;

    #[ORM\Column(length: 64)]
    private ?string $poblacion = null;

    #[ORM\Column(length: 64)]
    private ?string $pais = null;

    #[ORM\Column]
    private ?int $telefono = null;

    #[ORM\Column(length: 64)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNif(): ?int
    {
        return $this->nif;
    }

    public function setNif(int $nif): self
    {
        $this->nif = $nif;

        return $this;
    }

    public function getNombreFiscal(): ?string
    {
        return $this->nombre_fiscal;
    }

    public function setNombreFiscal(string $nombre_fiscal): self
    {
        $this->nombre_fiscal = $nombre_fiscal;

        return $this;
    }

    public function getNombreComercial(): ?string
    {
        return $this->nombre_comercial;
    }

    public function setNombreComercial(string $nombre_comercial): self
    {
        $this->nombre_comercial = $nombre_comercial;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getCodigoPostal(): ?int
    {
        return $this->codigo_postal;
    }

    public function setCodigoPostal(int $codigo_postal): self
    {
        $this->codigo_postal = $codigo_postal;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getPoblacion(): ?string
    {
        return $this->poblacion;
    }

    public function setPoblacion(string $poblacion): self
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function __toString()
    {
        return $this->nombre_fiscal;
    }
}
