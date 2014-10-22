<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Accident;

class Accidents extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //$ligne = $manager->getRepository('TramBundle:Ligne')->find(1);
        // $ligne = $this->getReference('ligneA');
        //
        // $accident = new Accident;
        // $accident->setName('Travaux');
        // $accident->setDate('Du 25 Juillet au 31 Août 2014');
        // $accident->setDescription('Travaux sur la ligne à la station Toto');
        //
        // $accident->setLigne($ligne);
        //
        // $manager->persist($accident);
        // $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
