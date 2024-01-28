<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{_locale}/', name: 'home', requirements: ['_locale' => 'en|fr'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/', name: 'home_withoutLangue', requirements: ['_locale' => 'en|fr'])]
    public function withoutLangue(): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl('home', ['_locale' => 'en']));
    }
}
