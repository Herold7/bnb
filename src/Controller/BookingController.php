<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Booking;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/bookings', name: 'bookings')]
    public function index(BookingRepository $bookingRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findBy([
                'traveler' => $this->getUser()
            ])
        ]);
    }

    // Route to make a booking
    #[Route('/book-a-room/{room}', name: 'book_room', methods: ['POST'])]
    public function bookRoom(
        Room $room, 
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $previous = $request->headers->get('referer');
        $user = $this->getUser();
        
        $newBooking = new Booking();
        $newBooking->setNumber(uniqid())
                ->setTraveler($user)
                ->setRoom($room)
                ->setCheckIn(new \DateTime($request->request->get('checkin')))
                ->setCheckOut(new \DateTime($request->request->get('checkout')))
                ->setOccupants($request->request->get('guests'))
                ->setCreatedAt(new \DateTime('now'))
                ;

        $user->addBooking($newBooking);
        $em->persist($newBooking);
        $em->flush();

        $this->addFlash('success', 'Room booked successfully.');
        return $this->redirect($previous);
    }

    #[Route('/bookings/{booking}', name: 'booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

}
