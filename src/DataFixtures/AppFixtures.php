<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Variation;
use App\Entity\VariationValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName("MANCHESTER UNITED HOME JERSEY");
        $product->setDescription("Manchester United's treble-winning team earned 
        the club a place in the record books and hearts of football fans worldwide. 
        This home jersey honours 20 years since that fateful night in Barcelona. 
        Made for fans, this version has a looser cut than the one players wear on match days. 
        It's built from sweat-wicking fabric, with commemorative details and a 
        special crest honouring their incredible 1998/99 season.");
        $manager->persist($product);

        $variation = new Variation();
        $variation->setName("Size");
        $manager->persist($variation);

        $variationValue = new VariationValue();
        $variationValue->setValue("XL");
        $variationValue->setVariation($variation);
        $manager->persist($variation);
        $manager->persist($variationValue);    
        $manager->flush();

        $product = $manager->getRepository('App\Entity\Product')->findOneBy([
            "name" => "MANCHESTER UNITED HOME JERSEY"
        ]);

        $product->getVariations()->add($variation);
        $manager->persist($variation);
        $manager->persist($product); 
        $manager->flush(); 
    }
}
