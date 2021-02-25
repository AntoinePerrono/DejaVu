<?php

namespace App\Entity;

use App\Repository\NoterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoterRepository::class)
 */
class Noter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLike;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="noters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="noters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsLike(): ?bool
    {
        return $this->isLike;
    }

    public function setIsLike(bool $isLike): self
    {
        $this->isLike = $isLike;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
