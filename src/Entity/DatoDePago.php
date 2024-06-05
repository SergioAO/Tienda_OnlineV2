<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DatoDePago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $numeroTarjeta = null;

    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private ?string $titularNombre = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $codigoDeSeguridad = null;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private ?string $direccionFacturacion = null;

    #[ORM\ManyToOne(inversedBy: 'datoDePago')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroTarjeta(): ?string
    {
        return $this->numeroTarjeta;
    }

    public function setNumeroTarjeta(string $numeroTarjeta): self
    {
        $this->numeroTarjeta = $numeroTarjeta;
        return $this;
    }

    public function getTitularNombre(): ?string
    {
        return $this->titularNombre;
    }

    public function setTitularNombre(string $titularNombre): self
    {
        $this->titularNombre = $titularNombre;
        return $this;
    }

    public function getCodigoDeSeguridad(): ?string
    {
        return $this->codigoDeSeguridad;
    }

    public function setCodigoDeSeguridad(string $codigoDeSeguridad): self
    {
        $this->codigoDeSeguridad = $codigoDeSeguridad;
        return $this;
    }

    public function getDireccionFacturacion(): ?string
    {
        return $this->direccionFacturacion;
    }

    public function setDireccionFacturacion(string $direccionFacturacion): self{
        $this->direccionFacturacion = $direccionFacturacion;
        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }
}