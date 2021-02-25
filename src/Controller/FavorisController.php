<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Favoris;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
    * @Route("/favoris", name="favoris")
    */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if($user == null)
        {
            //todo->return home
        }
        $favoris = $user->getFavoris();
        $fav = [];
        foreach ($favoris as $favori) {
            $fav[]=$favori->getMovieId();
        }

        return $this->render('favoris/index.html.twig', [
            'movies' => $fav
        ]);
    }

    /**
     * @Route("/favoris/add/{movie}", name="addToFav")
     */
    public function add(Movie $movie): Response
    {
        $user = $this->getUser();
        if($user!== null) {
            $fav = new Favoris();
            $fav->setUserId($user);
            $fav->setMovieId($movie);
            $this->entityManager->persist($fav);
            $this->entityManager->flush();
        }
        $slug = $movie->getSlug();
        return $this->redirectToRoute('movie', ['slug' => $slug]);
    }

    /**
     * @Route("/favoris/delete/{movie}", name="deleteToFav")
     */
    public function delete(Movie $movie): Response
    {
        $user = $this->getUser();
        if($user!== null) {
            $favori = $this->entityManager->getRepository(Favoris::class)->findOneBy(['movieId' => $movie, 'userId' => $user]);
            if ($favori !== null) {
                $this->entityManager->remove($favori);
                $this->entityManager->flush();
            }
        }
        $slug = $movie->getSlug();
        return $this->redirectToRoute('movie', ['slug' => $slug]);
    }

    public function verifInDb(User $user, Movie $movie)
    {
        return $this->entityManager->getRepository(Favoris::class)->findOneBy(['userId' =>$user, 'movieId' =>$movie]);
    }
}
