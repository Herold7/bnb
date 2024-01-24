<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Review;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('user/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/icon.svg" width="50">')
            ->setFaviconPath('/images/icon.svg')
            ->renderContentMaximized()
            ->setLocales([
                'en' => '🇬🇧 English',
                'pl' => '🇵🇱 Polski'
            ]);           
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Rooms', 'fa fa-list', Room::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Reviews', 'fa fa-star', Review::class);
        yield MenuItem::linkToRoute('Back to app', 'fa fa-arrow-left', 'app-room');
    }

    // public function configureUserMenu(UserInterface $user): UserMenu
    // {
    //     // Usually it's better to call the parent method because that gives you a
    //     // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
    //     // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
    //     return parent::configureUserMenu($user)
    //         // use the given $user object to get the user name
    //         ->setName($user->getFullname())
    //         // use this method if you don't want to display the name of the user
    //         ->displayUserName(false)

    //         // you can return an URL with the avatar image
    //         ->setAvatarUrl('/uploads/users/'. $user->getImage())
            
    //         ->addMenuItems([
    //             MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
    //         ]);
    // }
}
