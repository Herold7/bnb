<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    #[Route('/check-favorite', name: 'check_favorite', methods: ['POST'])]
    public function index(
        EntityManagerInterface $em,
        FavoriteRepository $favoriteRepository,
        Request $request
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // Get the form data & user
        // $roomNumber;
        // $status;
        if ($request->request->get('room')) {
        $roomNumber = $request->request->get('room');
            if ($request->request->get('room')) {
                $status = $request->request->get('stauts');
            }
            if ($status == 'true') {
                // Remove from favorite with object
            } else {
                // Add to favorite with object
            }

            // Persist changes
            // $em->persist($favorite);
            // $em->flush();
        }
        
        // Persist changes
        // Flash message to confirm the action
        // Redirect to the room page after checking the favorite
        return $this->redirectToRoute('app_room');
    }
}