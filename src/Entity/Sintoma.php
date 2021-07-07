<?php

namespace App\Entity;

use App\Repository\SintomaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SintomaRepository::class)
 */
class Sintoma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=UserSintomas::class, mappedBy="sintoma", orphanRemoval=true)
     */
    private $userSintomas;

    public function __construct()
    {
        $this->userSintomas = new ArrayCollection();
    }

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

    /**
     * @return Collection|UserSintomas[]
     */
    public function getUserSintomas(): Collection
    {
        return $this->userSintomas;
    }

    public function addUserSintoma(UserSintomas $userSintoma): self
    {
        if (!$this->userSintomas->contains($userSintoma)) {
            $this->userSintomas[] = $userSintoma;
            $userSintoma->setSintoma($this);
        }

        return $this;
    }

    public function removeUserSintoma(UserSintomas $userSintoma): self
    {
        if ($this->userSintomas->removeElement($userSintoma)) {
            // set the owning side to null (unless already changed)
            if ($userSintoma->getSintoma() === $this) {
                $userSintoma->setSintoma(null);
            }
        }

        return $this;
    }
}
