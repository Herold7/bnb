<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/r')] // prefix all room routes with /r
class RoomController extends AbstractController
{
    #[Route('/', name: 'app_room', methods: ['GET'])]
    public function index(
        RoomRepository $roomRepository,
        PaginatorInterface $paginator,
        Request $request,
    ): Response
    {
        $pagination = $paginator->paginate(
            $roomRepository->findAll(), // All rooms
            $request->query->getInt('page', 1), // Check page number
            12 // Items per page
        );

        return $this->render('room/index.html.twig', [
            'rooms' => $pagination,
            'hostRooms' => $roomRepository->findBy(
                ['host' => $this->getUser()]
                )
        ]);
    }

    #[Route('/{city}', name: 'app_room_city', methods: ['GET'])]
    public function city(
        RoomRepository $roomRepository,
        PaginatorInterface $paginator,
        Request $request,
    ): Response
    {
        $pagination = $paginator->paginate(
            $roomRepository->findBy(['city' => $request->attributes->get('city')]),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('room/rooms.html.twig', [
            'rooms' => $pagination,
        ]);
    }
}
