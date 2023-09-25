<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(JobOfferRepository $jobOfferRepository): Response
    {
        return $this->render('public/index.html.twig', [
            'jobOffers' => $jobOfferRepository->findAll()
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('public/contact.html.twig', []);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('public/about.html.twig', []);
    }
}
