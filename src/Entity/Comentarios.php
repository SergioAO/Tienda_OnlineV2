<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Comentarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $valoracion = null;

    #[ORM\OneToOne(inversedBy: 'comentarios', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compra $idCompra = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getValoracion(): ?int
    {
        return $this->valoracion;
    }

    public function setValoracion(int $valoracion): self
    {
        $this->valoracion = $valoracion;
        return $this;
    }

    public function getIdCompra(): ?Compra
    {
        return $this->idCompra;
    }

    public function setIdCompra(?Compra $idCompra): self
    {
        $this->idCompra = $idCompra;
        return $this;
    }
}