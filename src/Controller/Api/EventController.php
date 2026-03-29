<?php
namespace App\Controller\Api;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/events')]
class EventController extends AbstractController
{
    #[Route('', name: 'api_events', methods: ['GET'])]
    public function index(EventRepository $repo): JsonResponse
    {
        $events = $repo->findAll();
        $data = array_map(fn($e) => [
            'id' => $e->getId(),
            'title' => $e->getTitle(),
            'description' => $e->getDescription(),
            'date' => $e->getDate()->format('Y-m-d H:i'),
            'location' => $e->getLocation(),
            'seats' => $e->getSeats(),
        ], $events);

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'api_event_show', methods: ['GET'])]
    public function show(int $id, EventRepository $repo): JsonResponse
    {
        $event = $repo->find($id);
        if (!$event) {
            return new JsonResponse(['error' => 'Event not found'], 404);
        }

        return new JsonResponse([
            'id' => $event->getId(),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'date' => $event->getDate()->format('Y-m-d H:i'),
            'location' => $event->getLocation(),
            'seats' => $event->getSeats(),
        ]);
    }
}
