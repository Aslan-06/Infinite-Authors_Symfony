<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ConnexionFormType;
use App\Form\InscriptionFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\VarDumper\VarDumper;

class AuthentificationController extends AbstractController
{

    #[Route('/inscription', name: 'inscription')]
    public function inscription(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher){
        $utilisateur = new Utilisateur();

        $manager = $doctrine->getManager();
        $formInscription = $this->createForm(InscriptionFormType::class, $utilisateur);
        $formInscription->handleRequest($request);
        if($formInscription->isSubmitted() && $formInscription->isValid()){
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($hashedPassword);
            
            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('connexion');
        }

        return $this->render('authentification/inscription.html.twig', [
            'formInscription' => $formInscription->createView()
        ]);
    }

    #[Route('/connexion', name: 'connexion')]
    public function connexion(AuthenticationUtils $authenticationUtils){
        // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('authentification/connexion.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/deconnexion', name: 'deconnexion', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
    }
}
