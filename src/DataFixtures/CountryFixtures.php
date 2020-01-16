<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $country = new Country();
        $country->setName('France métropolitaine');
        $manager->persist($country);
        $this->addReference('country1', $country);
        $manager->flush();
    }
}
