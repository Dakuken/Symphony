<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function test()
    {
        return $this->render('home.html.twig', ['test' => 'SOLEIL !!']);
    }
}