<?php
namespace App\Service;

use App\Entity\Reservation;
use Swift;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class EmailService{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

        
    }

    public function sendReservationConfirm(string $to,string $clientName,string $reservationsDetails ):void{
        $email = (new Email())
        ->from('noreply@yourdomain.com')
        ->to($to)
        ->subject('Confirmation de réservation')
        ->html(sprintf(
            '<p>Bonjour %s,</p><p>Votre réservation a été confirmée avec les détails suivants :</p><p>%s</p>',
            $clientName,
            $reservationsDetails

        ));

        $this->mailer->send($email);

    }

    public function sendCodeCli(string $email,string $clientName,int $codeLivraison):void{

        $emailMessage = (new Email())
            ->from('noreply@example.com')
            ->to($email)
            ->subject('Votre code de livraison')
            ->text("Bonjour $clientName,\n\nVoici votre code de livraison : $codeLivraison.\n\nMerci pour votre commande.");

        $this->mailer->send($emailMessage);


    }

    public function sendReservationCancellation(Reservation $reservation):void {
        $email = (new Email())
              ->from('noreply@beshbarmaqfood.com')
              ->to($reservation->getClient()->getEmail())
              ->subject('Annulation de votre réservation')
              ->text(
                sprintf(
                    "Bonjour %s %s,\n\nNous sommes désolés de vous informer que votre réservation du %s a été annulée.\n\nN'hésitez pas à nous contacter pour toute question.",
                    $reservation->getClient()->getPrenom(), 
                    $reservation->getClient()->getNom(),    
                    $reservation->getDateReservation()->format('d/m/Y H:i')
   
  

                )
                );
                $this->mailer->send($email);


    }
}

