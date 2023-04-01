<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailerInterface, UrlGeneratorInterface $urlGeneratorInterface): Response
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

            // Attribution du role utilisateur (client)
            $user->setRoles(['ROLE_USER']);

            // L'entity manager
            $em = $doctrine->getManager();

            // Insère les données de la requête dans la classe User
            $em->persist($user);

            // On exécute la requête
            $em->flush();

            // Génère une URL de confirmation unique pour l'utilisateur
            $confirmationUrl = $urlGeneratorInterface->generate('confirm_registration', [
                'token' => $user->getEmailConfirmationToken(),
            ), UrlGeneratorInterface::ABSOLUTE_URL);

            // Envoi du mail de confirmation avec le tokken à l'interieur
            $email = (new Email())
                ->from('adresseMailDeAgence@gmail.com')
                ->to(new Address($user->getEmail()))
                ->subject('Confirmation de l\'inscription')
                ->html($this->renderView('emails/confirmation.html.twig',[
                    'user' => $user,

                ]));
                /*
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => 'foo',
                ])
                */
            $mailerInterface->send($email);

            return $this->redirectToRoute('page_accueil');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
