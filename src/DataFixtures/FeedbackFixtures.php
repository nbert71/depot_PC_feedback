<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Course;
use App\Entity\Feedback;
use Faker;

class FeedbackFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $roles = array("ROLE_USER", "ROLE_ADMIN");
        $matiere = array("Chimie-GP","Mathématiques", "Ondes et Signal", "Informatique", "Mécanique");
        $courses = array();

        //Creation de 4 course
        for($j = 0; $j <5; $j++) {
            $course = new Course();
            $course->setName($matiere[$j])
                    ->setIsUE(true)
                    ->setIsOptionGroup(false);

            $manager->persist($course);
            // $courses[$matiere[$j]] = $course;
        }

        // Creation de 5 users
        for($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName())
                ->setLastName($faker->lastName());
            $prenom = strtolower($user->getFirstName());
            $nom = strtolower($user->getLastName());
            $user->setUsername(substr($prenom, 0, 1) . $nom)
                ->setEmail($user->getUsername().'@ginfo.fr')
                ->setPassword($faker->password())
                ->setPromo(mt_rand(2000,2020));
            $user->setRoles([$roles[mt_rand(0, 1)]]);

            //Chaque user laisse un feedback sur chaque cours
            for($k = 0; $k < count($matiere); $k++) {
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

        $manager->flush();
    }
}
