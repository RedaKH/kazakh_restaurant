<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Entity\Reservation;
use App\Enum\CommandeStatus;
use App\Form\CodeLivraisonType;
use Doctrine\ORM\EntityManager;
use App\Entity\ReservationHistory;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EmployeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;
    private ReservationRepository $reservationRepository;

    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository, ReservationRepository $reservationRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->reservationRepository = $reservationRepository;
    }

    

    #[Route('/employe/dashboard', name: 'employe_dashboard')]
    public function dashboard(): Response
    {
        $reservations = $this->entityManager->getRepository(Reservation::class)->findAll();
        $employe = $this->getUser();

        return $this->render('employe/dashboard.html.twig', [
            'reservations' => $reservations,
            'employe' => $employe
        ]);
    }


    #[Route('/livreur/dashboard', name: 'livreur_dashboard')]

    public function verifyCodeLivraison(Request $request, Security $security): Response
    {
        $livreur = $security->getUser();

        // Récupérer les données directement depuis la requête
        $clientId = (int) $request->request->get('client_id');
        $codecli = (int) trim($request->request->get('code_cli'));

        // Rechercher la réservation associée à l'employé (livreur) et au client
        $reservation = $this->reservationRepository->findOneBy([
            'livreur' => $livreur,
            'client' => $clientId
        ]);

        if ($reservation === null) {
            $this->addFlash('danger', 'Réservation non trouvée ou vous n\'êtes pas assigné à cette livraison.');
        } else {
            // Vérifier la validité du code client
            if ($reservation->getClient()->getCodeClient() === $codecli) {
                // Si le code est valide, mettre à jour la commande comme livrée
                $reservation->getCommande()->setCommandeStatus([CommandeStatus::livre]);

                // Enregistrer dans l'historique
                $reservationHistory = new ReservationHistory();
                $reservationHistory->setClientName($reservation->getClient()->getNom() . ' ' . $reservation->getClient()->getPrenom());
                $reservationHistory->setClientEmail($reservation->getClient()->getEmail());
                $reservationHistory->setPlat($reservation->getPlat());
                $reservationHistory->setEmploye($livreur);
                $reservationHistory->setCommande($reservation->getCommande());
                $reservationHistory->setDateReservation($reservation->getDateReservation());
         $reservationHistory->setDateAccepted(new \DateTime()); //date actuelle
         $reservationHistory->setReservationType($reservation->getReservationType()->value);


                $this->entityManager->persist($reservationHistory);
                $this->entityManager->remove($reservation);
                $this->entityManager->flush();

                $this->addFlash('success', 'Le code de livraison est valide. Livraison confirmée et archivée.');
            } else {
                $this->addFlash('danger', 'Code de livraison invalide.');
            }
        }

        // Retourner la vue avec les réservations mises à jour
        $reservations = $this->reservationRepository->findBy(['livreur' => $livreur]);

        return $this->render('employe/livreur-dashboard.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route(path: '/livreur/search', name: 'search_delivery', methods: ['GET' , 'POST'])]

    public function searchDelivery(Request $request, Security $security) : Response  {

        $livreur = $security->getUser();

        $searchTerm = $request->get('search','');

        $reservations = [];

        if ($searchTerm) {
            $reservations = $this->reservationRepository->searchDelivery($livreur,$searchTerm);
            # code...
        } else {
            $reservations = $this->reservationRepository->findBy(['livreur'=>$livreur]);

        }

        return $this->render('employe/livreur-dashboard.html.twig',[
            'reservations'=>$reservations
        ]);
        
    }
    #[Route('/employe/rechercher-commande', name: 'rechercher_commande', methods: ['GET'])]
    public function rechercherCommande(Request $request, ReservationRepository $reservationRepository, Security $security): Response
    {
        $employe = $security->getUser();
        $searchTerm = $request->query->get('search', '');
        $reservations = [];
    
        if ($searchTerm) {
            $reservations = $reservationRepository->searchReservationsForEmploye($employe, $searchTerm);
        } else {
            $reservations = $reservationRepository->findBy(['employe' => $employe]);
        }
    
        return $this->render('employe/dashboard.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    

}
