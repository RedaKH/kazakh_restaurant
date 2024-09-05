<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Enum\ReservationType;
use App\Form\ClientReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/make_reservation', name: 'make_reservation')]
    public function add_reservation(Request $request,ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ClientReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          /*  $dateReservation = $reservation->getDateReservation();


            //appel de la méthode pour savoir si une date est disponible
            if (!$this->canReserveOnDate($dateReservation,$reservationRepository)) {
                $this->addFlash('danger','Impossible de réserver à cette date. Une privatisation est prévue');

                return $this->redirectToRoute('reservation_failure');
            } */
            $client = $reservation->getClient();

            //associer le client à la reservation
            if (!$client) {
                //Créer un nouveau client 
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
            $reservation->setClient($client);
            $reservation->setDateReservation(new \DateTimeImmutable());
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();


            // $this->sendConfirmationEmail($client);


            $this->addFlash('success', 'Reservation validé ! ');



            return $this->redirectToRoute('reservation_success');
        }

        return $this->render('reservation/make_reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
