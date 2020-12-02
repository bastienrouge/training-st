<?php

namespace App\Controller;

use App\Contact\Mailer;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods="GET")
     */
    public function homepage(): Response
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \App\Contact\ContactData $contactData */
            $contactData = $form->getData();

            $message = (new TemplatedEmail())
                ->from($contactData->email)
                ->to('contact@website.info')
                ->subject($contactData->subject)
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'message' => $contactData->message,
                ]);

            $mailer->send($message);

            $message = (new TemplatedEmail())
                ->to($contactData->email)
                ->from('contact@website.info')
                ->subject('Sent: ' . $contactData->subject)
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'message' => $contactData->message,
                ]);

            $mailer->send($message);
        }

        return $this->render('contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
