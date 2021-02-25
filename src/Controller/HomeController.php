<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Favoris;
use App\Entity\Movie;
use App\Entity\Noter;
use App\Form\CommentsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();

        return $this->render('home/index.html.twig', [
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/film/{slug}", name="movie")
     */
    public function show(Request $request, $slug): Response
    {

        $movie = $this->entityManager->getRepository(Movie::class)->findOneBySlug($slug);
        $nbLike = $this->entityManager->getRepository(Noter::class)->count(['movie' =>$movie]);
        //$comments = $movie->getComments();
        if($movie !== null)
        {

            if($this->getUser() !== null) {
                $comment = new Comments();
                $form = $this->createForm(CommentsType::class, $comment);
                $form->handleRequest($request);
                $favori = $this->entityManager->getRepository(Favoris::class)->findOneBy(['movieId' => $movie, 'userId' => $this->getUser()]);
                if ($form->isSubmitted() && $form->isValid())
                {
                    $user = $this->getUser();
                    $comment->setUser($user);
                    $comment->setMovie($movie);
                    $comment->setContent($form->getData()->getContent());
                    $date = new \DateTime();
                    $comment->setDate($date);
                    $this->entityManager->persist($comment);
                    $this->entityManager->flush();
                }

                unset($form);
                $form = $this->createForm(CommentsType::class, $comment);
                $comments = $this->entityManager->getRepository(Comments::class)->findBy(['movie'=>$movie->getId()], ['date'=> 'DESC']);
                return $this->render('home/show.html.twig', [
                    'movie' => $movie,
                    'favori' => $favori,
                    'note' => $movie->getNote(),
                    'nbLike' => $nbLike,
                    'commentForm' => $form->createView(),
                    'comments' => $comments
                ]);

            } else {
                $favori = null;
            }

        }else {
            return $this->redirectToRoute('home');
        }

        $comments = $this->entityManager->getRepository(Comments::class)->findBy(['movie'=>$movie->getId()], ['date'=> 'DESC']);

        return $this->render('home/show.html.twig', [
            'movie' => $movie,
            'favori' => $favori,
            'note' => $movie->getNote(),
            'nbLike' => $nbLike,
            'comments' => $comments
        ]);
    }
}
