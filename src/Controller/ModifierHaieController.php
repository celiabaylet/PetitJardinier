<?php

namespace App\Controller;

use App\Entity\Haie;
use Symfony\Component\HttpFoundation\Request;
use App\Form\HaieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ModifierHaieController extends AbstractController
{
    
    #[Route('modifier/haie/{code}', name: 'app_modifier_haie')]
    public function index(Request $request, EntityManagerInterface $entityManager, string $code): Response
    {
        // Recherche de la haie
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas : ' . $code);
        }

        // Création et gestion du formulaire
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications
            $entityManager->flush();

            // Redirection vers la liste des haies
            return $this->redirectToRoute('app_consultation_haie');
        }

        // Rendu du formulaire
        return $this->render('modifier_haie/index.html.twig', [
            'controller_name' => 'ModifierHaieController',
            'form' => $form->createView(),
            'haie' => $haie,
        ]);
    }
}
