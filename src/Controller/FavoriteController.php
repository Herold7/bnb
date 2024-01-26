<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Room;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FavoriteController extends AbstractController
{
    #[Route('/favorites', name: 'favorites', methods: ['GET'])]
    public function index(FavoriteRepository $favoriteRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('favorite/index.html.twig', [
            'favorites' => $favoriteRepository->findBy([
                'traveler' => $this->getUser()
            ])
        ]);
    }

    #[Route('/add-favorite/{room}', name: 'add_favorite', methods: ['GET'])]
    public function addFavorite(
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
        
        $newFavorite = new Favorite();
        $newFavorite->setTraveler($user);
        $newFavorite->addRoom($room);

        $user->addFavorite($newFavorite);
        $em->persist($newFavorite);
        $em->flush();

        $this->addFlash('success', 'Room added to favorites successfully.');
        return $this->redirect($previous);
    }

    #[Route('/remove-favorite/{room}', name: 'remove_favorite', methods: ['GET'])]
    public function removeFavorite(
        Request $request,
        FavoriteRepository $favoriteRepository,
        EntityManagerInterface $em
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $previous = $request->headers->get('referer');
        $user = $this->getUser();

        $favorite = $favoriteRepository->findOneBy([
            'traveler' => $user
        ]);

        if ($favorite) {
            $user->removeFavorite($favorite);
            $em->persist($user);
            $em->remove($favorite);
            $em->flush();
            $this->addFlash('success', 'Room removed from favorites successfully.');
        }

        // Redirect to the last page visited by the user
        return $this->redirect($previous);
    }
}