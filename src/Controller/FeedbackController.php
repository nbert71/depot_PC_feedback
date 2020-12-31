<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Feedback;
use App\Entity\User;
use App\Form\FeedbackType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class FeedbackController extends AbstractController
{
    //page qui fait je sais pas quoi encore
    /**
     * @Route("/feedback", name="feedback")
     */
    public function index()
    {
        return $this->render('feedback/index.html.twig', [
            'controller_name' => 'FeedbackController',
        ]);

    }

    //page d'accueil
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('feedback/home.html.twig');
    }


    //Creation d'un feedback

    /**
     * @Route("/new_feedback", name="new_feedback")
     */
    public function newFeedback(Request $request, User $user, EntityManagerInterface $manager)
    {
        $feedback = new Feedback();

        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on set l'auteur et est non modéré
            $feedback->setValid(false);
            $feedback->setAuthor($user);

            $manager->persist($feedback);
            $manager->flush();

            $this->addFlash(
                'success',
                'Ton feedback a été enregistré et est en attente de modération !'
            );

            // faut rediriger vers une route qui show le cours et les autres feedback de ce cours
            return $this->redirectToRoute('course_show', ["course_id" => $feedback->getCourse()->getId()]);
        }

        return $this->render('feedback/createFeedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //Un cours avec ses feedback
    /**
     * @Route("/course/{course_id}", name="course_show")
     */
    public function courseshow(Course $course, Request $request){

    }
}
