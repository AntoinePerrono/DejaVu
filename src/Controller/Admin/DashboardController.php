<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();
        $nbUser = sizeof($this->entityManager->getRepository(User::class)->findAll());
        $nb = sizeof($movies);
        //return parent::index();
        return  $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'nbFilms' => $nb,
            'nbUsers' => $nbUser
            ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DéjàVu?');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Films', 'fas fa-film', Movie::class);
        yield MenuItem::linkToCrud('Commentaire', 'fas fa-comments', Comments::class);
    }
}
