<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    /**
     * @Route("/feedback", name="feedback")
     */
    public function index() {
        if ($this->isGranted('ROLE_USER')) {
            return $this->render('feedback/index.html.twig', [
                'controller_name' => 'FeedbackController',
            ]);
        }
        else {
            return $this->redirectToRoute('security_login');
        }
    }

    /**
     * @Route("/home", name="home")
     */
    public function home() {
        if ($this->isGranted('ROLE_USER')) {
            return $this->render('feedback/home.html.twig');
        }
        else {
            return $this->redirectToRoute('security_login');
        }
    }
}
