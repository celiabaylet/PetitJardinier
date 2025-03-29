<?php

namespace App\Controller;

use App\Entity\Haie;
use App\Form\Haie1Type;
use App\Repository\HaieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/haie/c/r/u/d')]
final class HaieCRUDController extends AbstractController
{
    #[Route(name: 'app_haie_c_r_u_d_index', methods: ['GET'])]
    public function index(HaieRepository $haieRepository): Response
    {
        return $this->render('haie_crud/index.html.twig', [
            'haies' => $haieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_haie_c_r_u_d_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $haie = new Haie();
        $form = $this->createForm(Haie1Type::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($haie);
            $entityManager->flush();

            return $this->redirectToRoute('app_haie_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('haie_crud/new.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}', name: 'app_haie_c_r_u_d_show', methods: ['GET'])]
    public function show(Haie $haie): Response
    {
        return $this->render('haie_crud/show.html.twig', [
            'haie' => $haie,
        ]);
    }

    #[Route('/{code}/edit', name: 'app_haie_c_r_u_d_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Haie $haie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Haie1Type::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_haie_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('haie_crud/edit.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}', name: 'app_haie_c_r_u_d_delete', methods: ['POST'])]
    public function delete(Request $request, Haie $haie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$haie->getCode(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($haie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_haie_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
    }
}
