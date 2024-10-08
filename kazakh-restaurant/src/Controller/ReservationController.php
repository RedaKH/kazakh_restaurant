<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Reservation;
use App\Enum\CommandeStatus;
use App\Enum\ReservationType;
use App\Service\EmailService;
use App\Entity\ReservationHistory;
use App\Form\ClientReservationType;
use App\Repository\ReservationHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private $emailService;
    private $reservationRepository;
    private $reservationHistoryRepository;

    public function __construct(EntityManagerInterface $entityManager, 
    EmailService $emailService, 
    ReservationRepository $reservationRepository 
    ,
    ReservationHistoryRepository $reservationHistoryRepository // Injectez le repository ici

    )
    {
        $this->entityManager = $entityManager;
        $this->emailService = $emailService;
        $this->reservationRepository = $reservationRepository;
        $this->reservationHistoryRepository = $reservationHistoryRepository;
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
    #[Route('/reservation/accept/{id}', name: 'reservation_accept')]
        public function accept($id): Response
        {
            $reservation = $this->reservationRepository->find($id);
            if (!$reservation) {
                 throw $this->createNotFoundException('La reservation n\'existe pas');

            }

         //Enregistrer dans l'historique
         $reservationHistory = new ReservationHistory();
         $reservationHistory->setClientName($reservation->getClient()->getNom().' '.$reservation->getClient()->getPrenom());
         $reservationHistory->setClientEmail($reservation->getClient()->getEmail());
         $reservationHistory->setDateReservation($reservation->getDateReservation());
         $reservationHistory->setDateAccepted(new \DateTime()); //date actuelle
         $reservationHistory->setPlat($reservation->getPlat());
         $reservationHistory->setEmploye($reservation->getLivreur());
         $reservationHistory->setCommande($reservation->getCommande());
         $reservationHistory->setReservationType($reservation->getReservationType()->value);

         $this->entityManager->persist($reservationHistory);



         
            $this->entityManager->flush();
            $this->addFlash('success', 'La réservation a été acceptée');

            //supprime la reservation original
            $this->entityManager->remove($reservation);

            $this->entityManager->flush();

    
            return $this->redirectToRoute('employe_dashboard');
        }



        #[Route('/reservation/cancel/{id}', name: 'reservation_cancel')]
        public function cancel($id): Response
        {
            $reservation = $this->reservationRepository->find($id);
            if (!$reservation) {
                 throw $this->createNotFoundException('La reservation n\'existe pas');

            }


            $this->emailService->sendReservationCancellation($reservation);
            $this->entityManager->remove($reservation);

            $this->entityManager->flush();
            $this->addFlash('success', 'La réservation a été annulé');
    
            return $this->redirectToRoute('employe_dashboard');
        }

        #[Route('/reservation/history', name: 'reservation_history')]
        public function history(): Response
        {
            $history = $this->reservationHistoryRepository->findAll();

            return $this->render('reservation/history.html.twig',[
                'history'=>$history
            ]);
            
    
        }



        
}
