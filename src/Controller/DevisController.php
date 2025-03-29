<?php
namespace App\Controller;

use App\Entity\Devis;
use App\Entity\Tailler;
use App\Repository\HaieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DevisRepository;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis')]
    public function index(
        Request $request,
        HaieRepository $haieRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupération de l'utilisateur connecté
        $userInterface = $this->getUser();
        if (!$userInterface) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupération de l'utilisateur en base de données
        $identifiantUser = $userInterface->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $identifiantUser]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Récupération des données envoyées par le formulaire
        $type = $request->get('haie');
        $longueur = (float) $request->get('longueur');
        $hauteur = (float) $request->get('hauteur');

        $haie = $haieRepository->findOneBy(['code' => $type]);
        if (!$haie) {
            throw $this->createNotFoundException('Type de haie non trouvé.');
        }

        // Calcul du prix
        $prixUnitaire = $haie->getPrix();
        $total = ($hauteur > 1.50) ? $prixUnitaire * 1.50 * $longueur : $prixUnitaire * $longueur;

        // Vérification du type de client
        $choix = $user->getTypeClient();
        if ($choix === "entreprise") {
            $total -= $total * 0.10; // Remise de 10% si entreprise
        }

        // Création et persistance du devis
        $devis = new Devis();
        $devis->setUser($user); // On enregistre directement l'utilisateur
        $devis->setDate(new \DateTime());
        $devis->setNo(uniqid('DEV_'));

        $entityManager->persist($devis);

        // Création et persistance de l'objet Tailler
        $tailler = new Tailler();
        $tailler->setHauteur($hauteur);
        $tailler->setLongueur($longueur);
        $tailler->setHaie($haie);
        $tailler->setDevis($devis);
        $entityManager->persist($tailler);

        // Sauvegarde en base de données
        $entityManager->flush();

        return $this->render('devis/index.html.twig', [
            'choix' => $choix,
            'longueur' => $longueur,
            'hauteur' => $hauteur,
            'prix' => $total,
            'devis' => $devis,
            'taillers' => [$tailler] // On passe bien un tableau de taillers
        ]);
    }

    #[Route('/mes-devis', name: 'app_mes_devis')]
    public function mesDevis(
        DevisRepository $devisRepository,
    ): Response {
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos devis.');
        }

        // Récupération des devis de l'utilisateur connecté
        $devis = $devisRepository->findBy(['user' => $user]);

        return $this->render('devis/mes_devis.html.twig', [
            'devis' => $devis,
        ]);
    }


}
