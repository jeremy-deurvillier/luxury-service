<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
