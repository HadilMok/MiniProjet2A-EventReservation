<?php
namespace App\Controller\Admin;

use App\Repository\EventRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard')]
    public function index(EventRepository $eventRepo, ReservationRepository $reservationRepo): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'total_events' => count($eventRepo->findAll()),
            'total_reservations' => count($reservationRepo->findAll()),
            'latest_events' => $eventRepo->findAll(),
        ]);
    }
}
