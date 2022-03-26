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

class AuthentificationController extends AbstractController
{

    #[Route('/inscription', name: 'inscription')]
    #[Route('/connexion', name: 'connexion')]
    public function inscription(ManagerRegistry $doctrine, Request $request){
        $utilisateur = new Utilisateur();
        
        $manager = $doctrine->getManager();
        $formInscription = $this->createForm(InscriptionFormType::class, $utilisateur);
        $formInscription->handleRequest($request);
        if($formInscription->isSubmitted() && $formInscription->isValid()){
            $manager->persist($utilisateur);
            $manager->flush();
        }

        $formConnexion = $this->createForm(ConnexionFormType::class, $utilisateur);
    
        return $this->render('authentification/authentification.html.twig', [
            'formInscription' => $formInscription->createView(),
            'formConnexion' => $formConnexion->createView()
        ]);
    }
}
