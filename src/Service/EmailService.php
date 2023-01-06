<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    public function __construct(private readonly MailerInterface $mailer)
    {

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail($from, $subject, $message, $file = null): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to('no-reply@judo-club-wallers.fr')
            ->subject($subject)
            ->text($message);

        if ($file != null) {
            $email->attachFromPath($file);
        }

        $this->mailer->send($email);
    }
}