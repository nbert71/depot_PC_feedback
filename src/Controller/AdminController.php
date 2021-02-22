<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/menu", name="admin_menu")
     */
    public function index()
    {
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $nbuser = $repoUser->count_user();
        $users = $repoUser->findAll();
        $userOnline = $this->getUser();

        $repofb = $this->getDoctrine()->getRepository(Feedback::class);
        $fb_online = $repofb->countNbFbOnline();
        $fb_moderate = $repofb->countNbFbModerate();

        return $this->render('admin/admin.html.twig',
            [
                'count_user' => $nbuser,
                'count_fb_online' => $fb_online,
                'count_fb_moderate' => $fb_moderate,
                'users' => $users,
                'userOnline' => $userOnline
            ]);
    }

    /**
     * @Route("/set_admin/{id}", name="set_admin")
     */
    public function setAdmin(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            ($user->getFirstName()) . ' ' . ($user->getLastName()) . ' a bien été promu(e) administrateur.'
        );
        return $this->redirectToRoute('admin_menu');
    }

    /**
     * @Route("/remove_admin/{id}", name="remove_admin")
     */
    public function removeAdmin(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        $user_online = $this->getUser();
        if(($user->getRoles()[0]) == 'ROLE_ADMIN'){
            if($user_online->getId() == $user->getId()){
                $this->addFlash(
                    'danger',
                    'Vous ne pouvez pas vous retirer les droits.'
                );
            }else{
                $user->setRoles(["ROLE_USER"]);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "L'utilisateur a bien été destitué."
                );

            }
        }else{
            $this->addFlash(
                'warning',
                ($user->getFirstName()) . ' ' . ($user->getLastName()) . " n'est pas un administrateur."
            );
        }

        return $this->redirectToRoute('admin_menu');
    }


    /**
     * @Route("/set_modo/{id}", name="set_modo")
     */
    public function setModo(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        $user->setRoles(["ROLE_MODO"]);
        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            ($user->getFirstName()) . ' '. ($user->getLastName()) . ' a bien été promu modérateur.'
        );
        return $this->redirectToRoute('admin_menu');

    }

    /**
     * @Route("/remove_modo/{id}", name="remove_modo")
     */
    public function removeModo(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        if(($user->getRoles()[0]) == 'ROLE_MODO'){
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'utilisateur a bien été destituté."
            );

        }else{
            $this->addFlash(
                'warning',
                ($user->getFirstName()) . ' ' . ($user->getLastName()) . " n'est pas un modérateur."
            );
        }
        return $this->redirectToRoute('admin_menu');

    }
}
