<?php
namespace App\Controller\Admin;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/events')]
class AdminEventController extends AbstractController
{
    #[Route('/', name: 'admin_events')]
    public function index(EventRepository $repo): Response
    {
        return $this->render('admin/events/index.html.twig', [
            'events' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_event_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('admin_events');
        }

        return $this->render('admin/events/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}/edit', name: 'admin_event_edit')]
    public function edit(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_events');
        }

        return $this->render('admin/events/edit.html.twig', ['form' => $form, 'event' => $event]);
    }

    #[Route('/{id}/delete', name: 'admin_event_delete', methods: ['POST'])]
    public function delete(Event $event, EntityManagerInterface $em): Response
    {
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('admin_events');
    }

    #[Route('/{id}/reservations', name: 'admin_event_reservations')]
    public function reservations(Event $event, ReservationRepository $repo): Response
    {
        return $this->render('admin/events/reservations.html.twig', [
            'event' => $event,
            'reservations' => $repo->findByEvent($event->getId()),
        ]);
    }
}
