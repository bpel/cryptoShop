<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<20;$i++) {
            $product = new Product();
            $product->setName('product '. $i);
            $product->setPrice(random_int(2,35));
            $product->setQuantity(random_int(0,20));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
