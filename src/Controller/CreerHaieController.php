<?php

namespace App\Controller;
use App\Entity\Haie;
use App\Entity\Categorie;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\HaieType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;

class CreerHaieController extends AbstractController
{
    #[Route('/creer/haie', name: 'app_creer_haie')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $haie = new Haie();
        $form = $this->createForm(HaieType::class, $haie); 

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //a completer
            $haie->setCode($form->get('code')->getData());
            $haie->setNom($form->get('nom')->getData());
            $haie->setPrix($form->get('prix')->getData());

            
            $entityManager->persist($haie);
            $entityManager->flush();
            return new Response('Type de haie créé avec le code '.$haie->getCode());
        }
                 
        return $this->render('creer_haie/index.html.twig', array('form'=> $form->createView())
        );
    }
}
