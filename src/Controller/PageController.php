<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'paris')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
        ]);
    }

        // Test route for designing the confirmation
    #[Route('/email', name: 'email')]
    public function email(): Response
    {
        return $this->render('registration/confirmation_email.html.twig', [
            'signedUrl' => 'https://example.com/signed-url',
        ]);
    }
}
