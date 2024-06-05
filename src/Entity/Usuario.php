<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private ?string $apellidos = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(pattern:"/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", message:"La contraseña no es válida. Debe contener al menos 8 caracteres, un número, una letra mayúscula y una letra minúscula")]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Assert\Regex(pattern:"/^[\w]+\.(jpg|jpeg|png|webp)$/i", message:"Foto no válida")]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'idUsuario', targetEntity: Pedido::class, orphanRemoval: true)]
    private Collection $pedidos;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Pregunta::class, orphanRemoval: true)]
    private Collection $preguntas;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Respuesta::class, orphanRemoval: true)]
    private Collection $respuestas;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: DatoDePago::class, orphanRemoval: true)]
    private Collection $datoDePago;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): self
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos->add($pedido);
            $pedido->setIdUsuario($this);
        }
        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedidos->contains($pedido)) {
            $this->pedidos->removeElement($pedido);
            if ($pedido->getIdUsuario() === $this) {
                $pedido->setIdUsuario(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Pregunta>
     */
    public function getPreguntas(): Collection
    {
        return $this->preguntas;
    }

    public function addPregunta(Pregunta $pregunta): self
    {
        if (!$this->preguntas->contains($pregunta)) {
            $this->preguntas->add($pregunta);
            $pregunta->setUsuario($this);
        }
        return $this;
    }

    public function removePregunta(Pregunta $pregunta): self
    {
        if ($this->preguntas->contains($pregunta)) {
            $this->preguntas->removeElement($pregunta);
            if ($pregunta->getUsuario() === $this) {
                $pregunta->setUsuario(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Respuesta>
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuesta $respuesta): self
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas->add($respuesta);
            $respuesta->setUsuario($this);
        }
        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): self
    {
        if ($this->respuestas->contains($respuesta)) {
            $this->respuestas->removeElement($respuesta);
            if ($respuesta->getUsuario() === $this) {
                $respuesta->setUsuario(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, DatoDePago>
     */
    public function getDatoDePago(): Collection
    {
        return $this->datoDePago;
    }

    public function addDatoDePago(DatoDePago $datoDePago): self
    {
        if (!$this->datoDePago->contains($datoDePago)) {
            $this->datoDePago->add($datoDePago);
            $datoDePago->setUsuario($this);
        }
        return $this;
    }

    public function removeDatoDePago(DatoDePago $datoDePago): self
    {
        if ($this->datoDePago->contains($datoDePago)) {
            $this->datoDePago->removeElement($datoDePago);
            if ($datoDePago->getUsuario() === $this) {
                $datoDePago->setUsuario(null);
            }
        }
        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
