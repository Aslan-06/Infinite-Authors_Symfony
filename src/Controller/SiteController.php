<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Livre;
use App\Entity\Section;
use App\Entity\Texte;
use App\Form\ContenuPageFormType; 

class SiteController extends AbstractController
{
    #[Route('', name: '')]
    public function index(): Response
    {
        return $this->render('/accueil.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route('livres', name: 'livres')]
    public function livres(ManagerRegistry $doctrine): Response{

        $livres = $doctrine->getRepository(Livre::class)->findAll();

        return $this->render('livre/livres.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('livres/{idLivre}', name: 'tableDesMatieres')]
    public function tableDesMatieres(ManagerRegistry $doctrine, $idLivre): Response{
        $sections = $doctrine->getRepository(Section::class)->findBy(array("idlivre" => $idLivre), array("numsequence" => "asc"));

        //POST n'est pas vide si cette fonction sera executé par mode en ajax en cas de creation d'une section
        if(!empty($_POST)){
            extract($_POST);
            if(!empty($titreSection)){ // Le titre de nouvel section n'est pas vide
                //Augmentation de 1 de numDeSequence de ceux qui doivent etre apres la nouvelle section
                $sections = $doctrine->getRepository(Section::class)->findBy(array("idlivre" => $idLivre), array("numsequence" => "asc"), 500, $numSequence - 1);
                foreach($sections as $section){
                    $section->setNumsequence($section->getNumsequence() + 1);
                }

                $entityManager = $doctrine->getManager();

                $section = new Section();
                $section->setTitre($titreSection);
                $section->setNumsequence($numSequence);
                $section->setNiveau($niveau);
                $section->setIdlivre($idLivre);
                
                $entityManager->persist($section);
                $entityManager->flush();
            }
        }
        
        return $this->render('livre/tableDesMatieres.html.twig', [
            'sections' => $sections
        ]);
    }

    #[Route('livres/{idLivre}/{idSection}', name: 'page')]
    public function page(ManagerRegistry $doctrine, $idLivre, $idSection): Response{
        $sectionsRoute = array();

        $section = $doctrine->getRepository(Section::class)->find($idSection);
        $niveau = $section->getNiveau() + 1;
        $numSequence = $section->getNumsequence();
        $fromFirstToCurrentSections = $doctrine->getRepository(Section::class)->findBy(array("idlivre" => $idLivre), array("numsequence" => "asc"), $numSequence);
        $compteurInverse = count($fromFirstToCurrentSections) - 1;
        do{
            if($fromFirstToCurrentSections[$compteurInverse]->getNiveau() < $niveau){
                array_unshift($sectionsRoute, $fromFirstToCurrentSections[$compteurInverse]->getTitre()); // ajoute un element au premier rang
                $niveau--;
            }
            if($fromFirstToCurrentSections[$compteurInverse]->getNiveau() == 1)
                break;
            $compteurInverse--;
        }while($compteurInverse >= 0);

        $contenu = $doctrine->getRepository(Texte::class)->find($idSection);

        $contenuPage = new Texte();
        $formContenuPage = $this->createForm(ContenuPageFormType::class, $contenuPage);

        return $this->render('livre/page.html.twig', [
            'sectionsRoute' => $sectionsRoute,
            'contenu' => $contenu,
            'formContenuPage' => $formContenuPage->createView(),
            'idLivre' => $idLivre
        ]);
    }
    
}