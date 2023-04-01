<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        // Initialisé User
        $user = new User();

        // Instancier le formulaire
        $form = $this->createForm(RegisterType::class, $user);

        // La requête
        $form->handleRequest($request);

        // Condition de validation du formulaire (de la requête)
        if ($form->isSubmitted() && $form->isValid()){

            // L'entity manager
            $em = $doctrine->getManager();

            // Mot de passe encodé
            $password_encode = $encoder->encodePassword($user, $user->getPassword());

            // Remplacer le password non encodé par le password encodé
            $user->setPassword($password_encode);

            // Insère les données de la requête dans la classe User
            $em->persist($user);

            // On exécute la requête
            $em->flush();
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
