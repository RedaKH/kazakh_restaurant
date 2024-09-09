<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Reservation;
use App\Enum\CommandeStatus;
use App\Enum\ReservationType;
use App\Service\EmailService;
use App\Form\ClientReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private $emailService;
    private $reservationRepository;

    public function __construct(EntityManagerInterface $entityManager, EmailService $emailService, ReservationRepository $reservationRepository)
    {
        $this->entityManager = $entityManager;
        $this->emailService = $emailService;
        $this->reservationRepository = $reservationRepository;
    }

    #[Route('/make_reservation', name: 'make_reservation', methods: ['GET', 'POST'])]
    public function addReservation(Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ClientReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des champs non mappés pour l'entité Client

            $commande = new Commande();
            $client = $reservation->getClient();
            $commande->setDateCommande(new \DateTimeImmutable());
            $commande->setCommandeStatus([CommandeStatus::en_preparation]);

            $this->entityManager->persist($commande);

            $reservation->setCommande($commande);

            // Récupération de la date de réservation
            $dateReservation = $reservation->getDateReservation();

            // Vérifier si la date est une instance de DateTime et la convertir en DateTimeImmutable si nécessaire
            if ($dateReservation instanceof \DateTime && !$dateReservation instanceof \DateTimeImmutable) {
                $dateReservation = new \DateTimeImmutable('2024-09-09 00:00:00', new \DateTimeZone('UTC'));
            }


            // Vérifier si une privatisation existe déjà pour la date donnée
            if ($reservation->getReservationType() === ReservationType::PRIVATISATION) {
                $canReserve = $this->reservationRepository->canReserveOnDate($dateReservation);


                if (!$canReserve) {
                    $this->addFlash('danger', 'Impossible de réserver à cette date car une privatisation sera effectuée');
                    return $this->redirectToRoute('make_reservation');
                }
            }

            if (!$client) {
                $client = new Client();
                $client->setNom($form->get('client_nom')->getData());
                $client->setPrenom($form->get('client_prenom')->getData());
                $client->setAdresse($form->get('client_adresse')->getData());
                $client->setCodePostal($form->get('client_code_postal')->getData());
                $client->setVille($form->get('client_ville')->getData());
                $client->setEmail($form->get('client_email')->getData());
                $client->setNumTel($form->get('client_num_tel')->getData());

                $this->entityManager->persist($client);
            }

            $this->entityManager->flush();

            $reservation->setClient($client);
     
             // Appel de la méthode pour gérer le code de livraison
        $this->handleLivraison($reservation);

            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            $clientEmail = $client->getEmail();
            $clientName = $client->getNom() . ' ' . $client->getPrenom();
            $reservationDetails = sprintf(
                "Type: %s, Date: %s",
                $reservation->getReservationType()->value,
                $reservation->getDateReservation()->format('Y-m-d H:i:s')
            );

            $this->emailService->sendReservationConfirm($clientEmail, $clientName, $reservationDetails);

            $this->addFlash('success', 'Réservation enregistrée avec succès et email envoyé !');
        }

        return $this->render('reservation/make_reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function handleLivraison(Reservation $reservation){
        if ($reservation->getReservationType()===ReservationType::LIVRAISON) {
            
        
            $client = $reservation->getClient();
            $codeLivraison = random_int(10000,99999);
            $client->setCodeClient($codeLivraison);

            $this->emailService->sendCodeCli($client->getEmail(), $client->getNom(),$codeLivraison);
            $this->entityManager->persist($client);

        }




    }
}
