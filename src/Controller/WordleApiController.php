<?php

// src/Controller/Api/WordleApiController.php

namespace App\Controller;

use App\Entity\WordleConfiguration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class WordleApiController extends AbstractController
{
    #[Route('/api/wordle/{id}', name: 'api_wordle')]
    public function getWordleData(int $id,EntityManagerInterface $entityManager): JsonResponse
    {
        $wordle = $entityManager->getRepository(WordleConfiguration::class)->find($id);

        if (!$wordle) {
            // Gérer le cas où le wordle n'est pas trouvé
            return $this->json(['error' => 'Wordle not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $wordleData = [
            'id' => $wordle->getId(),
            'solution' => $wordle->getSolution(),
            'maxTries' => $wordle->getMaxTries(),
            // Ajoutez d'autres propriétés si nécessaire
        ];

        return $this->json($wordleData);
    }
}
