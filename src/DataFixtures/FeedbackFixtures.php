<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Course;
use App\Entity\Feedback;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FeedbackFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function fctRetirerAccents($varMaChaine)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        //Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $varMaChaine = str_replace($search, $replace, $varMaChaine);
        return $varMaChaine; //On retourne le résultat
    }

    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        $matiere = array("Chimie-GP","Mathématiques", "Ondes et Signal", "Informatique", "Mécanique");

        //Creation de 4 course
        for($j = 0; $j <5; $j++) {
            $course = new Course();
            $course->setName($matiere[$j])
                ->setIsUE(true)
                ->setIsOptionGroup(false);

            $manager->persist($course);
            // $courses[$matiere[$j]] = $course;



            // Creation de 5 users
            for ($i = 0; $i < 5; $i++) {
                $user = new User();
                $user->setFirstName($this->fctRetirerAccents($faker->firstName()))
                    ->setLastName($this->fctRetirerAccents($faker->lastName()));
                $prenom = strtolower($user->getFirstName());
                $nom = strtolower($user->getLastName());
                $user->setUsername(substr($prenom, 0, 1) . $nom)
                    ->setEmail($user->getUsername() . '@ginfo.fr')
                    ->setPromo(mt_rand(2000, 2020));
                $user->setRoles(['ROLE_USER']);

                $password = $this->encoder->encodePassword($user, $faker->password());
                $user->setPassword($password);

                //Chaque user laisse un feedback sur chaque cours
                for ($k = 0; $k < count($matiere); $k++) {
                    $fb = new Feedback();
                    $fb->setAuthor($user)
                        ->setCourse($course)
                        ->setTitle($faker->realText($maxNbChars = 20, $indexSize = 2))
                        ->setComment($faker->realText($maxNbChars = 100, $indexSize = 4))
                        ->setOverall(mt_rand(0, 5))
                        ->setDifficulty(mt_rand(0, 5))
                        ->setInterest(mt_rand(0, 5))
                        ->setValid(true);

                    $manager->persist($fb);
                }
                $manager->persist($user);
            }
        }

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setFirstName('Admin');
        $admin->setLastName('Boss');
        $admin->setEmail('admin@ginfo.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPromo('1945');
        $password = $this->encoder->encodePassword($user, 'coucou');
        $admin->setPassword($password);

        $manager->persist($admin);

        for ($p=1; $p<4; $p++) {
            $modo = new User();
            $modo->setUsername('modo'.$p);
            $modo->setFirstName('Modo'.$p);
            $modo->setLastName('Boss');
            $modo->setEmail('modo'.$p.'@ginfo.com');
            $modo->setRoles(['ROLE_MODO']);
            $modo->setPromo('1990');
            $password = $this->encoder->encodePassword($user, 'blabla');
            $modo->setPassword($password);

            $manager->persist($modo);
        }
        $manager->flush();
    }
}
