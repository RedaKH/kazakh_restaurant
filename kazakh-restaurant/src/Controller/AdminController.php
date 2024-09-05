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
        //trouve les reservations qui n'ont pas été attribué et de type livraison
        $reservations = $reservationRepository->findby([
            'livreur_id' => null,
            'ReservationType' => ReservationType::livraison
        ]);

        $livreurs = $employeRepository->findByRole(['ROLE_LIVREUR']);

        if ($request->isMethod('POST')) {
            $reservationID = $request->request->get('reservation_id');
            $livreurID = $request->request->get('livreur_id');

            $reservation = $reservationRepository->find($reservationID);
            $livreur = $employeRepository->find($livreurID);

            if ($reservation && $livreur) {
                $reservation->setLivreurID($livreur);

                $this->entityManager->flush();
                $this->addFlash('success', 'Livreur assigné avec succès');
                return $this->redirectToRoute('assigner_livraison');
                # code...
            } else {
                $this->addFlash('danger', 'Une erreur est survenue lors de l\'assignation.');
            }


            # code...
        }


        return $this->render('admin/dashboard_livraison.html.twig', [
            'reservations' => $reservations,
            'livreurs' => $livreurs
        ]);
    }
}
