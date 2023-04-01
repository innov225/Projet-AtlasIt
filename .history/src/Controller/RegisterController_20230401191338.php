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
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        // Création d'une instance de la classe user
        $user = new User();

        // Insertion de la date actuelle dans l'entité user
        $user->setCreateAt(new \DateTimeImmutable());
        $user->setUploatAt(new \DateTimeImmutable());

        // Instancier le formulaire
        $form = $this->createForm(RegisterType::class, $user);

        // La requête
        $form->handleRequest($request);

        // Condition de validation du formulaire (de la requête)
        if ($form->isSubmitted() && $form->isValid()){

            // $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));

            // L'entity manager
            $em = $doctrine->getManager();

            // Insère les données de la requête dans la classe User
            $em->persist($user);

            // On exécute la requête
            $em->flush();

            // Génère un token unique
            $user->setEmailConfirmationToken(md5(uniqid()));

            // Envoi du mail de confirmation à l'utilisateur
            //$emailVerifier->send
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
