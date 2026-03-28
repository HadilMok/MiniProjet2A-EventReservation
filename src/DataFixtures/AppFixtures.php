<?php
namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin->setUsername('admin');
        $admin->setPassword(password_hash('admin123', PASSWORD_BCRYPT));
        $manager->persist($admin);

        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setPassword(password_hash('password' . $i, PASSWORD_BCRYPT));
            $manager->persist($user);
        }

        $events = [
            ['Concert Jazz', 'Un magnifique concert de jazz', '2026-05-10 20:00', 'Tunis', 100],
            ['Festival Tech', 'Festival des technologies', '2026-06-15 09:00', 'Sousse', 200],
            ['Exposition Art', 'Exposition dart moderne', '2026-07-20 10:00', 'Sfax', 150],
            ['Conférence IA', 'Conference sur lintelligence artificielle', '2026-08-05 14:00', 'Tunis', 300],
            ['Marathon', 'Marathon annuel de la ville', '2026-09-12 07:00', 'Monastir', 500],
        ];

        foreach ($events as [$title, $desc, $date, $location, $seats]) {
            $event = new Event();
            $event->setTitle($title);
            $event->setDescription($desc);
            $event->setDate(new \DateTime($date));
            $event->setLocation($location);
            $event->setSeats($seats);
            $manager->persist($event);
        }

        $manager->flush();
    }
}
