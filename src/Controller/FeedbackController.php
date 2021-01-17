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
    //page d'accueil à modifier
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        $repoCourse = $this->getDoctrine()->getRepository(Course::class);
        $courses = $repoCourse->find();

        return $this->render('feedback/home.html.twig', [
            'courses' => $courses
        ]);
    }


    //Creation d'un feedback

    /**
     * @Route("/new_feedback", name="new_feedback")
     */
    public function newfeedback(Request $request, EntityManagerInterface $manager)
    {
        $feedback = new Feedback();

        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on set l'auteur et est non modéré
            $feedback->setValid(false);
            $feedback->setAuthor($this->getUser());

            $manager->persist($feedback);
            $manager->flush();

            $this->addFlash(
                'success',
                'Ton feedback a été enregistré et est en attente de modération !'
            );

            // faut rediriger vers une route qui show le cours et les autres feedback de ce cours
            return $this->redirectToRoute('course_show', [
                'course_id' => $feedback->getCourse()->getId(),
                'course_name' => $feedback->getCourse()->getName(),
            ]);
        }

        return $this->render('feedback/createFeedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    //Un cours avec ses feedback
    /**
     * @Route("/course/{course_id}", name="course_show")
     */
    public function courseshow($course_id)
    {
        $repo = $this->getDoctrine()->getRepository(Course::class);
        $course = $repo->find($course_id);
        $feedbacks = $course->getFeedback();

        if (!$course){
            throw $this->createNotFoundException('Aucun cours trouvé pour l\'id '.$course_id);
        }

        return $this->render('feedback/show_course.html.twig', [
            'course' => $course,
            'feedbacks' => $feedbacks
            ]);
    }
}
