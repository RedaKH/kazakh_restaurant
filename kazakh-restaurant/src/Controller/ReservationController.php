<?php // src/Controller/ReservationController.php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Reservation;
use App\Enum\CommandeStatus;
use App\Form\ClientReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            $reservation->setDateReservation(new \DateTimeImmutable());

            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            $this->addFlash('success', 'Réservation enregistrée avec succès !');

            return $this->redirectToRoute('reservation_success');
        }

        return $this->render('reservation/make_reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
