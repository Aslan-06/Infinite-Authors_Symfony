<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Texte;
use App\Entity\Section;
use App\Entity\Utilisateur;
use App\Form\ContenuPageFormType; 
use Symfony\Component\Form\FormView;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('livres/creerLivre', name: 'creationLivre')]
    public function creerLivre(ManagerRegistry $doctrine): Response{
        $utilisateur = $this->getUser();
        if(isset($_POST['titre']) && isset($_POST['image'])){
            $entityManager = $doctrine->getManager();

            $livre = new Livre();
            $livre->setTitre($_POST['titre']);
            $livre->setImagelien($_POST['image']);
            $livre->setAuteur($utilisateur);
            
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('tableDesMatieres', ['livre' => $livre->getId()]);
        }
    }

    #[Route('livres/{livre}', name: 'tableDesMatieres')]
    public function tableDesMatieres(ManagerRegistry $doctrine, Livre $livre): Response{
        $sections = $doctrine->getRepository(Section::class)->findBy(array("livre" => $livre), array("numsequence" => "asc"));

        //POST n'est pas vide si cette fonction sera executé par mode en ajax en cas de creation d'une section
        if(!empty($_POST)){
            extract($_POST);
            if(!empty($titreSection)){ // Le titre de nouvel section n'est pas vide
                //Augmentation de 1 de numDeSequence de ceux qui doivent etre apres la nouvelle section
                $sections = $doctrine->getRepository(Section::class)->findBy(array("livre" => $livre), array("numsequence" => "asc"), 500, $numSequence - 1);
                foreach($sections as $section){
                    $section->setNumsequence($section->getNumsequence() + 1);
                }

                $entityManager = $doctrine->getManager();

                $section = new Section();
                $section->setTitre($titreSection);
                $section->setNumsequence($numSequence);
                $section->setNiveau($niveau);
                $section->setlivre($livre);
                
                $entityManager->persist($section);
                $entityManager->flush();

                $contenuPage = new Texte();
                $contenuPage->setContenu("");
                $contenuPage->setIdsection($section);

                $entityManager->persist($contenuPage);
                $entityManager->flush();
            }
        }
        
        return $this->render('livre/tableDesMatieres.html.twig', [
            'sections' => $sections
        ]);
    }

    #[Route('livres/{livre}/{idSection}', name: 'page')]
    public function page(ManagerRegistry $doctrine, Livre $livre, $idSection): Response{
        $section = $doctrine->getRepository(Section::class)->find($idSection);
        $textes = $doctrine->getRepository(Texte::class)->findBy(array("idsection" => $section));
        $texte = $textes[0]; //on en a toujours 1, (toujours 1 element dans array retourné)
    
        if(isset($_POST['contenu_page_form']['contenu'])){
            $entityManager = $doctrine->getManager();

            $texte->setContenu($_POST['contenu_page_form']['contenu']);

            $entityManager->persist($texte);
            $entityManager->flush();

            unset($_POST['contenu_page_form']);
        }

        $sectionsRoute = array();

        $niveau = $section->getNiveau() + 1;
        $numSequence = $section->getNumsequence();
        $fromFirstToCurrentSections = $doctrine->getRepository(Section::class)->findBy(array("livre" => $livre), array("numsequence" => "asc"), $numSequence);
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

        
        $contenu = strip_tags($texte->getContenu());
        $formContenuPage = $this->createForm(ContenuPageFormType::class, $texte);

        return $this->render('livre/page.html.twig', [
            'sectionsRoute' => $sectionsRoute,
            'contenu' => $contenu,
            'formContenuPage' => $formContenuPage->createView(),
            'livre' => $livre
        ]);
    }
}