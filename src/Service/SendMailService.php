<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
//This class send the mails
class SendMailService
{ //propieté mailer
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    //mail parametres in the send function
    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context //variables
    ): void {
        //mail creation with à classe
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("email/$template.html.twig")
            ->context($context);

        // send the mail
        $this->mailer->send($email);
    }
}
