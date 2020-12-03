<?php

namespace App\Contact;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactMailer
{

// Property injection:

//    /** @required */
//    public MailerInterface $mailer;


// Constructor injection:

    private $mailer;

    public function __construct(MailerInterface $mailer, string $internalContactEmail)
    {
        $this->mailer = $mailer;
    }

// Setter injection:

//    /** @required */
//    public function setMailer(MailerInterface $mailer): void
//    {
//        $this->mailer = $mailer;
//    }

    public function sendMessageFromData(ContactData $contactData)
    {

        $message = (new TemplatedEmail())
            ->from($contactData->email)
            ->to('contact@website.info')
            ->subject($contactData->subject)
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                          'message' => $contactData->message,
                      ]);

        $this->mailer->send($message);

        $message = (new TemplatedEmail())
            ->to($contactData->email)
            ->from('contact@website.info')
            ->subject('Sent: ' . $contactData->subject)
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                          'message' => $contactData->message,
                      ]);

        $this->mailer->send($message);
    }
}

