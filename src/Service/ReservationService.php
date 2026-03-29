<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ReservationService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendConfirmationEmail(string $email, string $name, string $eventTitle): void
    {
        $message = (new Email())
            ->from('noreply@eventbook.com')
            ->to($email)
            ->subject('Confirmation de réservation — ' . $eventTitle)
            ->html('<p>Bonjour ' . $name . ', votre réservation pour <strong>' . $eventTitle . '</strong> est confirmée !</p>');

        $this->mailer->send($message);
    }
}
