<?php

namespace App\DataFixtures;

use App\Entity\WordleDictionary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Word extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $filePath = __DIR__ . '/liste.txt';
        
        $words = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($words as $word) {
            $wordDictionary = new WordleDictionary();
            $wordDictionary->setWord($word);
            $manager->persist($wordDictionary);
        }
        $manager->flush();
    }
}
