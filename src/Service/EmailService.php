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
    public function sendEmail($from, $subject, $message): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to('no-reply@judo-club-wallers.fr')
            ->subject($subject)
            ->text($message);
        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailWithPieceJoin($from, $subject, $message, $file): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to('no-reply@judo-club-wallers.fr')
            ->subject($subject)
            ->text($message)
            ->attachFromPath($file);
        $this->mailer->send($email);
    }
}