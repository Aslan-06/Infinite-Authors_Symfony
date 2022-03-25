<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{

    #[Route('/inscription', name: 'inscription')]
    #[Route('/connexion', name: 'connexion')]
    public function inscription(){
        $utilisateur = new Utilisateur();


        $formInscription = $this->createForm(InscriptionFormType::class, $utilisateur);
        $formConnexion = $this->createForm(InscriptionFormType::class, $utilisateur);
    
        return $this->render('authentification/inscription.html.twig', [
            'formInscription' => $formInscription->createView(),
            'formConnexion' => $formConnexion->createView()
        ]);
    }
}
