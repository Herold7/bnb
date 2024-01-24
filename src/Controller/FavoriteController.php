<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Room;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    #[Route('/add-favorite/{room}', name: 'add_favorite', methods: ['GET'])]
    public function addFavorite(
        Room $room, 
        EntityManagerInterface $em
        ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $newFavorite = new Favorite();
        $newFavorite->setTraveler($user);
        $newFavorite->addRoom($room);

        $user->addFavorite($newFavorite);
        $em->persist($newFavorite);
        $em->flush();

        $this->addFlash('success', 'Room added to favorites successfully.');
        return $this->redirectToRoute('app_room');
    }

    #[Route('/remove-favorite/{room}', name: 'remove_favorite', methods: ['GET'])]
    public function removeFavorite(
        FavoriteRepository $favoriteRepository,
        EntityManagerInterface $em
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        $favorite = $favoriteRepository->findOneBy([
            'traveler' => $user
        ]);

        if ($favorite) {
            $user->removeFavorite($favorite);
            $em->remove($favorite);
            $em->flush();
            $this->addFlash('success', 'Room removed from favorites successfully.');
        }

        return $this->redirectToRoute('app_room');
    }
}
