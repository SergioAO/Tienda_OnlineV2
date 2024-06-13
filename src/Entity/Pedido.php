<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private ?string $direccion;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $idUsuario = null;
    #[ORM\OneToMany(targetEntity: Compra::class, mappedBy: 'idPedido')]
    private Collection $compras;

    // Constructor para inicializar la colección compras
    public function __construct()
    {
        $this->compras = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;
        return $this;
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

    public function getIdUsuario(): ?Usuario
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?Usuario $idUsuario): self
    {
        $this->idUsuario = $idUsuario;
        return $this;
    }

    /**
     * @return Collection<int, Compra>
     */
    public function getCompras(): Collection
    {
        return $this->compras;
    }

    public function addCompra(Compra $compra): self
    {
        if (!$this->compras->contains($compra)) {
            $this->compras->add($compra);
            $compra->setIdPedido($this);
        }
        return $this;
    }

    public function removeCompra(Compra $compra): self
    {
        if ($this->compras->contains($compra)) {
            $this->compras->removeElement($compra);
            if ($compra->getIdPedido() === $this) {
                $compra->setIdPedido(null);
            }
        }
        return $this;
    }

    public function getTotal(): float
    {
        $total = 0.0;

        foreach ($this->compras as $compra) {
            $total += floatval($compra->getPrecio_compra());
        }

        return $total;
    }

    public function getTotalConIva(): float
    {
        return $this->getTotal() * 1.21; // Multiplicamos el total por 1.21 para incluir el IVA
    }
}