<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Service\ProfileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/complete-profile', name: 'complete_profile')]
    public function index(
        Request $request,
        ProfileService $profileService,
        EntityManagerInterface $em
    ): Response
    {
        $form = $this->createForm(ProfileType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $profileService->updateProfile($form, $this->getUser(), $em);
            
            $this->addFlash('success', 'Your profile has been updated');
            return $this->redirectToRoute('account');
        }
        return $this->render('user/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * User account route for displaying it's own data on the app
     */
    #[Route('/account', name: 'account', methods: ['GET', 'POST'])]
    public function account(
        Request $request,
        EntityManagerInterface $em,
        ProfileService $profileService
    ): Response
    {
        if(!$this->getUser()->getFirstname()) {
            return $this->redirectToRoute('complete_profile');
        }

        $form = $this->createForm(ProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $profileService->updateProfile($form, $this->getUser(), $em);
            $this->addFlash('success', 'Your profile has been updated');
            return $this->redirectToRoute('account');
        }
        return $this->render('user/account.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}