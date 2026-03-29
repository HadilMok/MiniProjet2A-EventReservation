<?php
namespace App\Controller\Api;

use App\Entity\Reservation;
use App\Repository\EventRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/reservations')]
class ReservationController extends AbstractController
{
    #[Route('', name: 'api_reservations', methods: ['GET'])]
    public function index(ReservationRepository $repo): JsonResponse
    {
        $reservations = $repo->findAll();
        $data = array_map(fn($r) => [
            'id' => $r->getId(),
            'name' => $r->getName(),
            'email' => $r->getEmail(),
            'phone' => $r->getPhone(),
            'event' => $r->getEvent()->getTitle(),
        ], $reservations);

        return new JsonResponse($data);
    }

    #[Route('', name: 'api_reservation_create', methods: ['POST'])]
    public function create(Request $request, EventRepository $eventRepo, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $event = $eventRepo->find($data['event_id']);
        if (!$event) {
            return new JsonResponse(['error' => 'Event not found'], 404);
        }

        $reservation = new Reservation();
        $reservation->setEvent($event);
        $reservation->setName($data['name']);
        $reservation->setEmail($data['email']);
        $reservation->setPhone($data['phone']);

        $em->persist($reservation);
        $em->flush();

        return new JsonResponse(['message' => 'Reservation created'], 201);
    }
}
