<?php

namespace App\Controller;

use App\Entity\Feedback;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@IsGranted("ROLE_MODO")
 */
class ModoController extends AbstractController
{

    /**
     * @Route("/moderation", name="moderation")
     */
    public function moderation(){
        $repofb = $this->getDoctrine()->getRepository(Feedback::class);
        $fb_moderate = $repofb->findnonvalid();
        $countfbmoderate = $repofb->countNbFbModerate();

        return $this->render('modo/moderation.html.twig', [
            'fb_moderate' => $fb_moderate
        ]);
    }

    /**
     * @Route("/valid_feedback/{id}", name="valid_feedback")
     */
    public function validFeedback(Feedback $feedback){
        $manager = $this->getDoctrine()->getManager();
        $feedback->setValid(true);
        $manager->persist($feedback);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le feedback a été modéré et publié !'
        );

        return $this->redirectToRoute('moderation');
    }
}
