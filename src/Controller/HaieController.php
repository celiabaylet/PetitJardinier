<?php

namespace App\Controller;

use App\Entity\Haie;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HaieRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HaieController extends AbstractController
{

    #[Route('/haie/creer', name: 'app_haie_creer')]
    public function haie_creer(EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $categorie->setLibelle('Persistant'); 

        $haie = new Haie();
        $haie->setCode('LA');
        $haie->setNom('Laurier');
        $haie->setPrix(30);

        //relates this product to the category
        $haie->setCategorie($categorie);

        $entityManager->persist($categorie);
        $entityManager->persist($haie);

        $entityManager->flush();
        return new Response('Type de haie créé avec le code '.$haie->getCode().' et nouvelle catégorie avec id: '.$categorie->getId()
    );
    }

    #[Route('/haie/{code}', name: 'app_haie_voir')]
    public function haie_voir(EntityManagerInterface $entityManager, string $code): Response
    {
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        
        $libelleCategorie = $haie->getCategorie()->getLibelle();
        
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas  '.$code);
        }
        else {
            return new Response('Type de haie : '.$haie->getNom().' à '.$haie->getPrix().' euros');
        }
    }

    #[Route('/haie/modifier/{code}', name: 'app_haie_modifier')]
    public function modifier_haie(EntityManagerInterface $entityManager, string $code): Response
    {
    // A COMPLETER
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas  '.$code);
        }
        else {
            $haie->setPrix('30');
            $entityManager->flush();
            return new Response('Type de haie : '.$haie->getNom().' à '.$haie->getPrix().' euros');
        }    
    return $this->redirectToRoute('app_haie_voir', ['code' => $haie->getCode()]);
    }

    #[Route('/haie/supprimer/{code}', name: 'app_haie_supprimer')]
    public function supprimer_haie(EntityManagerInterface $entityManager, string $code): Response
    {
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas  '.$code);
        }
        else {
            $entityManager->remove($haie);
            $entityManager->flush();
            return new Response('Type de haie supprimé');
        }
    }
       
    //voir les haies
    #[Route('/mesure', name: 'app_haie')]
    public function index(HaieRepository $haieRepository): Response
    {
        $mesHaies = $haieRepository->findAll();
        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'HaieController',
            'mesHaies' => $mesHaies,
        ]);
    }

}
?>
