<?php

// src/Controller/WordlePlayController.php

namespace App\Controller;

use App\Entity\WordleConfiguration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WordlePlayController extends AbstractController
{
    #[Route('/wordleplay/{id}', name: 'wordle_play', requirements: ['_locale' => 'en|fr'])]
    public function play(string $id,EntityManagerInterface $entityManager): Response
    {

        $wordle = $entityManager->getRepository(WordleConfiguration::class)->find($id);

        if (!$wordle) {
            return $this->redirectToRoute('home'); // Remplacez 'some_route' par la route de redirection appropriée
        }
        // Vous pouvez récupérer des détails supplémentaires du wordle ici si nécessaire

        return $this->render('wordle_play/index.html.twig');
    }
}
