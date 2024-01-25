<?php

namespace App\Controller;

use App\Repository\WordleDictionaryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    #[Route('/test/word/{word}', name: 'test_word')]
    public function testWord(WordleDictionaryRepository $wordRepository, string $word): Response
    {
        $wordObject = $wordRepository->findByWord($word);

        if (!$wordObject) {
            return new Response('Word not found');
        }

        return new Response('Found word: ' . $wordObject->getWord());
    }
}