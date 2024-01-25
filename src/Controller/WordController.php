<?php

namespace App\Controller;

use App\Repository\WordleDictionaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WordController extends AbstractController
{
    #[Route('/api/word/{word}', name: 'api_word_search', methods: ['GET'])]
    public function getWord(WordleDictionaryRepository $wordRepository, string $word): JsonResponse
    {
        $wordData = $wordRepository->findByWord($word);

        if (!$wordData) {
            return new JsonResponse(['error' => 'Word not found'], 404);
        }

        return new JsonResponse($wordData->getWord()); // Assurez-vous que $wordData est sérialisable en JSON
    }
}
