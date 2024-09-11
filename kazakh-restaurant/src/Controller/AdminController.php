<?php

namespace App\Controller;

use App\Enum\ReservationType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/assigner-livraison', name: 'app_admin')]
    public function assignerLivraison(Request $request, ReservationRepository $reservationRepository, EmployeRepository $employeRepository): Response
    {
        // Trouve les réservations qui n'ont pas été attribuées et sont de type livraison
        $reservations = $reservationRepository->findBy([
            'livreur_id' => null,
            'ReservationType' => ReservationType::LIVRAISON
        ]);

        // Trouve les employés ayant le rôle de livreur
        $livreurs = $employeRepository->findByRole('ROLE_LIVREUR');

        if ($request->isMethod('POST')) {
            $reservationID = $request->request->get('reservation_id');
            $livreurID = $request->request->get('employe_id');

            $reservation = $reservationRepository->find($reservationID);

            if ($reservation && $livreurID) {
                $reservation->setLivreurId($livreurID);  // Assigne l'ID du livreur

                $this->entityManager->flush(); 
                $this->addFlash('success', 'Livreur assigné avec succès');
                return $this->redirectToRoute('app_admin');
            } else {
                $this->addFlash('danger', 'Une erreur est survenue lors de l\'assignation.');
            }
        }

        return $this->render('admin/dashboard_livraison.html.twig', [
            'reservations' => $reservations,
            'livreurs' => $livreurs
        ]);
    }
    
    
}
