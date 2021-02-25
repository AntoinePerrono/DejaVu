<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $notification = null;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user= $form->getData();
            $emailIsValid = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$emailIsValid) {
                $password = $encoder->encodePassword($user,$user->getPassword());
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $notification = "Vous êtes bien inscrit. Vous pouvez dès à présent vous connecter.";
            } else {
                $notification = "L'email appartient déjà à un compte.";
            }
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
