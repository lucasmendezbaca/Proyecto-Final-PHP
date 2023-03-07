<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use App\Entity\LineaFactura;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne]
    private ?Estado $estado = null;

    #[ORM\OneToMany(mappedBy: 'factura', targetEntity: LineaFactura::class)]
    private Collection $lineaFacturas;

    // private float $total;

    public function __construct()
    {
        $this->lineaFacturas = new ArrayCollection();
        // $this->total = $this->calcularTotal();
        // $this->total = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getEstado(): ?Estado
    {
        return $this->estado;
    }

    public function setEstado(?Estado $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    // public function getTotal(): float
    // {
    //     return $this->total;
    // }

    public function calcularTotal(): float
    {
        $total = 0;
        foreach ($this->lineaFacturas as $lineaFactura) {
            $total += $lineaFactura->getProducto()->getPrecio() * $lineaFactura->getCantidad();
        }
        // $this->total = $total;
        return $total;
    }

    /**
     * @return Collection<int, LineaFactura>
     */
    public function getLineaFacturas(): Collection
    {
        return $this->lineaFacturas;
    }

    public function addLineaFactura(LineaFactura $lineaFactura): self
    {
        if (!$this->lineaFacturas->contains($lineaFactura)) {
            $this->lineaFacturas->add($lineaFactura);
            $lineaFactura->setFactura($this);
        }

        return $this;
    }

    public function removeLineaFactura(LineaFactura $lineaFactura): self
    {
        if ($this->lineaFacturas->removeElement($lineaFactura)) {
            // set the owning side to null (unless already changed)
            if ($lineaFactura->getFactura() === $this) {
                $lineaFactura->setFactura(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id . ' - ' . $this->getCliente(). ' - ' . $this->getFecha()->format('d/m/Y');
    }
}
