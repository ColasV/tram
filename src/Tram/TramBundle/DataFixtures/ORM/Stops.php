<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Ligne;

class Stops extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ligne = $manager->getRepository('TramBundle:Ligne')->find(1);
        $ligne_2 = $manager->getRepository('TramBundle:Ligne')->find(2);

        $stop = new Stop;
        $stop->setName('Toto');
        $stop->setCode('Coucou');
        $stop->setLat('1.0');
        $stop->setLng('1.0');

        $ligne->addStop($stop);

        $stop = new Stop;
        $stop->setName('Tutu');
        $stop->setCode('Lol');
        $stop->setLat('1.0');
        $stop->setLng('1.0');

        $ligne->addStop($stop);
        $ligne_2->addStop($stop);

        $manager->persist($stop);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
