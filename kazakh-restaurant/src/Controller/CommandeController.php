<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Reservation;
use App\Enum\CommandeStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/commande/validate/{id}', name: 'app_commande')]
    public function validateReservation(Reservation $reservation): Response
    {
        $commande = new Commande();
        $commande->setDateCommande( new \DateTimeImmutable());
        $commande->setPlat($reservation->getPlat());
        $commande->setCommandeStatus([CommandeStatus::en_preparation]);

        $this->entityManager->persist($commande);
        $this->entityManager->flush();

        
        return $this->redirectToRoute('reservation_confirmation',['id'=>$reservation->getId()]);
    }
}
