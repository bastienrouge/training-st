<?php

namespace App\Controller;

use App\Contact\ContactMailer;
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
    public function contact(Request $request, ContactMailer $contactMailer): Response
    {
        $form = $this->createForm(ContactType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMailer->sendMessageFromData($form->getData());
        }

        return $this->render('contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
