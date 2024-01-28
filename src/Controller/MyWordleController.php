<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyWordleController extends AbstractController
{
    #[Route('/my/wordle', name: 'app_my_wordle')]
    public function index(): Response
    {
        return $this->render('my_wordle/index.html.twig', [
            'controller_name' => 'MyWordleController',
        ]);
    }
}
