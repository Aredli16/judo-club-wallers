<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    public function __construct(private readonly MailerInterface $mailer)
    {

    }

    public function sendEmail($from,$subject,$message){
        $email = (new TemplatedEmail())
            ->from($from)
            ->to('no-reply@judo-club-wallers.fr')
            ->subject($subject)
            ->text($message);
        $this->mailer->send($email);
    }
}