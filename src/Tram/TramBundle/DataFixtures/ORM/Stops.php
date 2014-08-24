<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Ligne;

class Stops implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ligne = $manager->getRepository('TramBundle:Ligne')->find(1);

        $stop = new Stop;
        $stop->setName('Toto');
        $stop->setCode('Coucou');
        $stop->setLat('1.0');
        $stop->setLng('1.0');

        $ligne->addStop($stop);

        //$manager->persist($stop);
        $manager->flush();

    }
}
