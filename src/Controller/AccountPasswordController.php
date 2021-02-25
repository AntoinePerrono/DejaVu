<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */
    public function __construct( EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/resetPassword", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $oldPwd = $form->get('oldPassword')->getData();
            if($encoder->isPasswordValid($user, $oldPwd))
            {
                $newPwd = $form->get("newPassword")->getData();
                $password = $encoder->encodePassword($user, $newPwd);
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "Votre mot de passe a bien été mis à jour";
            }
            else
                $notification = "Erreur de mise à jour: mot de passe acutel non valide";
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
