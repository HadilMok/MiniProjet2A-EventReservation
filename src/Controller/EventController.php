<?php
namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\EventRepository;
use App\Service\ReservationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(EventRepository $repo): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $repo->findAll(),
        ]);
    }

    #[Route('/events/{id}', name: 'app_event_show')]
    public function show(int $id, EventRepository $repo): Response
    {
        $event = $repo->find($id);
        return $this->render('event/show.html.twig', ['event' => $event]);
    }

    #[Route('/events/{id}/reserve', name: 'app_event_reserve')]
    public function reserve(int $id, EventRepository $repo, Request $request, EntityManagerInterface $em, ReservationService $reservationService): Response
    {
        $event = $repo->find($id);
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setEvent($event);
            $em->persist($reservation);
            $em->flush();
            $reservationService->sendConfirmationEmail(
                $reservation->getEmail(),
                $reservation->getName(),
                $event->getTitle()
            );
            return $this->render('reservation/confirmation.html.twig', [
                'reservation' => $reservation,
                'event' => $event,
            ]);
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form,
            'event' => $event,
        ]);
    }
}
