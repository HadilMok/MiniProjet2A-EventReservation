<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Création d'un utilisateur Test
        $user = new User();
        $user->setEmail('admin@test.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, 'password123');
        $user->setPassword($password);
        $manager->persist($user);

        // 2. Création de quelques événements pour le Front
        $titles = ['Sommet de l\'IA', 'Web2Day 2026', 'Symfony Con Tunis', 'Hackathon FIA3'];
        foreach ($titles as $title) {
            $event = new Event();
            $event->setTitle($title);
            $event->setDescription("Découvrez les dernières innovations sur $title. Un événement incontournable pour les étudiants FIA3-GL.");
            // Si ta propriété s'appelle capacity ou maxCapacity, ajuste ici :
            if (method_exists($event, 'setCapacity')) { $event->setCapacity(50); }
            $manager->persist($event);
        }

        $manager->flush();
    }
}
