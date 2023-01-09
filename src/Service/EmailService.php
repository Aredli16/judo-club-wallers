<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    private $params;

    public function __construct(private readonly MailerInterface $mailer, ParameterBagInterface $params)
    {
        $this->params = $params;
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
            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->params->get('file_upload_email'),
                $fileName
            );
            $filePath = $this->params->get('file_upload_email') . $fileName;

            $email->attachFromPath($filePath);
        }
        $this->mailer->send($email);
        if ($file != null) {
            unlink($filePath);
        }
    }
}