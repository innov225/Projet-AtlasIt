<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // Création d'une instance de la classe user
        $user = new User();

        // Instancier le formulaire
        $form = $this->createForm(RegisterType::class, $user);

        // La requête
        $form->handleRequest($request);

        // Condition de validation du formulaire (de la requête)
        if ($form->isSubmitted() && $form->isValid()){

            // Encodage du mot de passe
            $password = $form->get('password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($encodedPassword);

            // Générez un token unique pour la confirmation d'e-mail
            $token = bin2hex(random_bytes(16));
            $user->setEmailConfirmationToken($token);

            // Envoi du mail de confirmation avec le tokken à l'interieur
            $email = (new Email())
                ->from('adresseMailDeAgence@gmail.com')
                ->to(new Address($user->getEmail()))
                ->subject('Confirmation de l\'inscription')
                ->html($this->renderView('emails/confirmation.html.twig',[
                    'user' => $user
                ]));
                /*
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => 'foo',
                ])
                */

            // Attribution du role utilisateur (client)
            $user->setRoles(['ROLE_USER']);

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
