<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Service\ProfileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    #[Route('/', name: 'paris', methods: ['GET'])]
    public function paris(): Response
    {
        return $this->render('page/city.html.twig', [
            'title' => 'Paris',
            'city' => 'paris',
            'background' => 'paris',
        ]);
    }

    #[Route('/lasvegas', name: 'lasvegas', methods: ['GET'])]
    public function lasvegas(): Response
    {
        return $this->render('page/city.html.twig', [
            'title' => 'Las Vegas',
            'city' => 'las vegas',
            'background' => 'lasvegas',
        ]);
    }

    #[Route('/kyoto', name: 'kyoto', methods: ['GET'])]
    public function kyoto(): Response
    {
        return $this->render('page/city.html.twig', [
            'title' => 'Kyoto',
            'city' => 'kyoto',
            'subtitle' => '京都市',
            'background' => 'kyoto',
        ]);
    }

    #[Route('/sydney', name: 'sydney', methods: ['GET'])]
    public function sydney(): Response
    {
        return $this->render('page/city.html.twig', [
            'title' => 'Sydney',
            'city' => 'sydney',
            'background' => 'sydney',
        ]);
    }
    #[Route('/hongkong', name: 'hongkong', methods: ['GET'])]
    public function hongkong(): Response
    {
        return $this->render('page/city.html.twig', [
            'title' => 'Hong Kong',
            'city' => 'hong kong',
            'subtitle' => '香港',
            'background' => 'hongkong',
        ]);
    }
}
