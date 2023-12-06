<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Pain;
use App\Entity\Product;
use App\Entity\Sauce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    private const IMAGE_REFERENCE = 'Image';
    
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i++) {      
            $image = new Image();
            $image->setUrl(sprintf('images/burgers/burger-%d.jpg', $i));
            $image->setAltText('Une image d\'un burger exceptionnel! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $i, $image);
        }

        $manager->flush();
    }
}