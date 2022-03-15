<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Livre;
use App\Entity\Section;

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

    #[Route('livres/{livreId}', name: 'livre')]
    public function tableDesMatieres(ManagerRegistry $doctrine, $livreId): Response{
        
        $sections = $doctrine->getRepository(Section::class)->findBy(array("idlivre" => $livreId), array("numsequence" => "asc"));

        return $this->render('livre/tableDesMatieres.html.twig', [
            'sections' => $sections
        ]);
    }

    #[Route('livres/{livreId}/new-section/{titre}', name:'new-section')]
    public function creerSection(ManagerRegistry $doctrine, $livreId, $titre): Response{
        $sectionRepository = $doctrine->getRepository(Section::class);
        $section = new Section();
        $section->setTitre($titre);
        $section->setNumSequence($sectionRepository->count() + 1);
        $section->setIdLivre($livreId);

        
        return $this->json(['message'=> 'Ca marche bien'], 200);
    }
    #[Route('livres/{livreId}/new-section/{idSession}/{titre}', name:'new-section')]
    public function creerSousSection(ManagerRegistry $doctrine, $livreId, $idSession, $titre): Response{
        $sectionRepository = $doctrine->getRepository(Section::class);
        $section = new Section();
        $section->setTitre($titre);
        $section->setNumSequence($sectionRepository->count() + 1);
        $section->setIdLivre($livreId);
        return $this->json(['message'=> 'Ca marche bien'], 200);
    }
    
}