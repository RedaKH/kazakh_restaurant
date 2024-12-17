<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Reservation;

class EmailService{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendReservationConfirm(string $to, string $clientName, string $reservationDetails): void
    {
        try {
            $email = (new Email())
                ->from('contact@beshbarmaqfood.redakhaldi.eu')
                ->to($to)
                ->subject('Confirmation de votre réservation')
                ->html($this->createConfirmationEmail($clientName, $reservationDetails));

            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Log l'erreur ou gérez-la comme vous le souhaitez
            throw new \Exception('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    public function sendReservationCancellation(Reservation $reservation): void
    {
        try {
            if (!$reservation->getClient() || !$reservation->getClient()->getEmail()) {
                throw new \Exception('Information client manquante');
            }

            $email = (new Email())
                ->from('contact@beshbarmaqfood.redakhaldi.eu')
                ->to($reservation->getClient()->getEmail())
                ->subject('Annulation de votre réservation')
                ->html($this->createCancellationEmail($reservation));

            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Log l'erreur ou gérez-la comme vous le souhaitez
            throw new \Exception('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    public function sendCodeCli(string $to, string $clientName, string $code): void
    {
        try {
            $email = (new Email())
                ->from('contact@beshbarmaqfood.redakhaldi.eu')
                ->to($to)
                ->subject('Votre code de livraison')
                ->html($this->createCodeEmail($clientName, $code));

            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Log l'erreur ou gérez-la comme vous le souhaitez
            throw new \Exception('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    private function createConfirmationEmail(string $clientName, string $reservationDetails): string
    {
        return "<h1>Confirmation de réservation</h1>
                <p>Bonjour {$clientName},</p>
                <p>Votre réservation a bien été enregistrée.</p>
                <p>Détails : {$reservationDetails}</p>";
    }

    private function createCancellationEmail(Reservation $reservation): string
    {
        return "<h1>Annulation de réservation</h1>
                <p>Bonjour {$reservation->getClient()->getNom()},</p>
                <p>Votre réservation a été annulée.</p>";
    }

    private function createCodeEmail(string $clientName, string $code): string
    {
        return "<h1>Code de livraison</h1>
                <p>Bonjour {$clientName},</p>
                <p>Voici votre code de livraison : {$code}</p>";
    }
}

