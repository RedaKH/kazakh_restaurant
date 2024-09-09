<?php
namespace App\Service;

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
}

