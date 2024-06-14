<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class NotificacionStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Producto::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Producto $producto;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Usuario $usuario;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $fechaSolicitud;

    // Getters y setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    public function setProducto(Producto $producto): self
    {
        $this->producto = $producto;
        return $this;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getFechaSolicitud(): \DateTime
    {
        return $this->fechaSolicitud;
    }

    public function setFechaSolicitud(\DateTime $fechaSolicitud): self
    {
        $this->fechaSolicitud = $fechaSolicitud;
        return $this;
    }
}
