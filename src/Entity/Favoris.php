<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="favoris")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movieId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favoris")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieId(): ?Movie
    {
        return $this->movieId;
    }

    public function setMovieId(?Movie $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


}
