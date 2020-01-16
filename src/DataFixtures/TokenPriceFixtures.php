<?php

namespace App\DataFixtures;

use App\Entity\TokenPrice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TokenPriceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tokenPrice = new TokenPrice();
        $tokenPrice->setName('XMR');
        $tokenPrice->setPrice(52);
        $tokenPrice->setDateUpdate(new \DateTime());
        $manager->persist($tokenPrice);

        $manager->flush();
    }
}
