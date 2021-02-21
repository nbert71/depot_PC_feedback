<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;

class MailEndSemesterCommand extends Command
{
    protected static $defaultName = 'app:mail-end-semester';

    private $em;
    private $mailer;
    private $twig;

    public function __construct(EntityManagerInterface $manager, \Swift_Mailer $mailer, Environment $twig)
    {
        parent::__construct();
        $this->em = $manager;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    protected function configure()
    {
        $this
            ->setDescription('Envoie un mail à tous les utilisateurs pour leur rappeler de laisser des avis.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $repo = $this->em->getRepository(User::class);
        $users = $repo->findAll();

        foreach ($users as $user){
                $email = $user->getEmail();
                $message = (new \Swift_Message('Ton avis est important !'))
                    ->setFrom('ginfo@centrale-marseille.fr')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            'mail/MailEndSemester.html.twig',
                            ['user' => $user]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
                echo('mail envoyé');

        }

        $io->success('Tous les mails on été envoyés.');
        return true;
    }


}

