<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Noter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/note/like/{movie}", name="like")
     */
    public function like(Movie $movie): Response
    {
        $user = $this->getUser();
        if($user!== null)
        {
            $note = $this->entityManager->getRepository(Noter::class)->findOneBy(['user' => $user, 'movie'=>$movie]);
            if($note != null ) {
                if($note->getIsLike() !== true) {
                    $note->setUser($user);
                    $note->setMovie($movie);
                    $note->setIsLike(true);
                    $movie->setNote($movie->getNote() + 2);
                }
            }else{
                $note = new Noter();
                $note->setUser($user);
                $note->setMovie($movie);
                $note->setIsLike(true);
                $movie->setNote($movie->getNote() + 1);
            }

            $this->entityManager->persist($note);
            $this->entityManager->persist($movie);
            $this->entityManager->flush();
        }
        $slug = $movie->getSlug();
        return $this->redirectToRoute('movie', ['slug' => $slug]);
    }

    /**
     * @Route("/note/dislike/{movie}", name="dislike")
     */
    public function dislike(Movie $movie): Response
    {
        $user = $this->getUser();
        if($user!== null)
        {
            $note = $this->entityManager->getRepository(Noter::class)->findOneBy(['user' => $user, 'movie'=>$movie]);
            if($note != null ) {
                if($note->getIsLike() !== false) {
                    $note->setUser($user);
                    $note->setMovie($movie);
                    $note->setIsLike(false);
                    $movie->setNote($movie->getNote() - 2);
                }
            }else{
                $note = new Noter();
                $note->setUser($user);
                $note->setMovie($movie);
                $note->setIsLike(false);
                $movie->setNote($movie->getNote() - 1);
            }

                $this->entityManager->persist($note);
                $this->entityManager->persist($movie);
                $this->entityManager->flush();
        }
        $slug = $movie->getSlug();
        return $this->redirectToRoute('movie', ['slug' => $slug]);
    }
}
