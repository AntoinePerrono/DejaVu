<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $note = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbNote= 0;

    /**
     * @ORM\OneToMany(targetEntity=Favoris::class, mappedBy="movieId", orphanRemoval=true)
     */
    private $favoris;

    /**
     * @ORM\OneToMany(targetEntity=Noter::class, mappedBy="movie", orphanRemoval=true)
     */
    private $noters;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="movie", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->favoris = new ArrayCollection();
        $this->noters = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNbNote(): ?int
    {
        return $this->nbNote;
    }

    public function setNbNote(int $nbNote): self
    {
        $this->nbNote = $nbNote;

        return $this;
    }

    /**
     * @return Collection|Favoris[]
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
            $favori->setMovieId($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getMovieId() === $this) {
                $favori->setMovieId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Noter[]
     */
    public function getNoters(): Collection
    {
        return $this->noters;
    }

    public function addNoter(Noter $noter): self
    {
        if (!$this->noters->contains($noter)) {
            $this->noters[] = $noter;
            $noter->setMovie($this);
        }

        return $this;
    }

    public function removeNoter(Noter $noter): self
    {
        if ($this->noters->removeElement($noter)) {
            // set the owning side to null (unless already changed)
            if ($noter->getMovie() === $this) {
                $noter->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMovie($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovie() === $this) {
                $comment->setMovie(null);
            }
        }

        return $this;
    }
}
