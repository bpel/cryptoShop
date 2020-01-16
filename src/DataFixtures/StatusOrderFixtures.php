<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StatusOrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $statusList = ['commande enregistré', 'attente paiement', 'paiement accepté', 'paiement refusé', 'paiement expiré', 'commande en préparation', 'commande prête', 'commande expédié', 'cloturé'];

        for ($i = 0; $i < count($statusList); $i++) {
            $statusOrder = new Status();
            $statusOrder->setName($statusList[$i]);

            $manager->persist($statusOrder);
            $this->addReference('statusorder'.$i, $statusOrder);
        }

        $manager->flush();
    }
}
