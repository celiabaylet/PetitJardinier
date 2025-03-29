<?php

namespace App\Controller;

use App\Entity\Haie;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\HaieRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConsultationHaieController extends AbstractController
{
    #[Route('/consultation/haie', name: 'app_consultation_haie')]
    public function index(HaieRepository $haieRepository): Response
    {

        //findAll
        $lesHaies = $haieRepository->findAll();
        return $this->render('consultation_haie/index.html.twig', [
            'controller_name' => 'ConsultationHaieController',
            'lesHaies' => $lesHaies,

        ]);
        
    }
}
