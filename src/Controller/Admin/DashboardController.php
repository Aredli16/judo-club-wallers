<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Article;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Judo Club Wallers');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Articles', 'fa-solid fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Album', 'fa-solid fa-photo-film', Album::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class)->setPermission('ROLE_ADMIN');
    }
}
