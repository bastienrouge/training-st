<?php

namespace App\Controller;

use App\Contact\Mailer;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

}
