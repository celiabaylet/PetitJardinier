<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\HaieRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MesureController extends AbstractController
{
    #[Route('/mesure', name: 'app_mesure')]
    public function index(HaieRepository $haieRepository): Response
    {
        $haies = $haieRepository->findAll();
        $request = Request::createFromGlobals();
        $choix=$request->get('choix');

        $session = new Session();
        $session->set('choix', $choix);
        

        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'Controller',
            'haies' => $haies,
        ]);


     
   
    }
}
