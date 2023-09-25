<?php

namespace App\Controller\Admin;

use App\Entity\Candidacy;
use App\Entity\Candidate;
use App\Entity\Client;
use App\Entity\JobCategory;
use App\Entity\JobOffer;
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
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Luxury Service');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Voir le site', 'fa fa-sitemap', 'app_home');
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Clients');
        yield MenuItem::linkToCrud('Tous les clients', 'fa fa-building', Client::class);

        yield MenuItem::section('Offres d\'emploi');
        yield MenuItem::linkToCrud('Toutes les offres', 'fa fa-briefcase', JobOffer::class);

        yield MenuItem::section('Catégories');
        yield MenuItem::linkToCrud('Toutes les catégories', 'fa fa-filter', JobCategory::class);

        yield MenuItem::section('Candidats');
        yield MenuItem::linkToCrud('Tous les candidats', 'fa fa-user', Candidate::class);

        yield MenuItem::section('Candidatures');
        yield MenuItem::linkToCrud('Toutes les candidatures', 'fa fa-file-text', Candidacy::class);
    }
}
