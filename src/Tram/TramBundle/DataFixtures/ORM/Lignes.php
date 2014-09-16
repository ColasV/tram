<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Destination;

class Lignes extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ligne = new Ligne;
        $ligne->setName('Tram A');
        $ligne->setCode('A');
        $ligne->setLogo('tramA.png');

        $departure = new Destination;
        $departure->setName('ECHIROLLES DENIS PAPIN');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('FONTAINE LA POYA');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $this->addReference('ligneA', $ligne);

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Tram B');
        $ligne->setCode('B');
        $ligne->setLogo('tramB.png');

        $departure = new Destination;
        $departure->setName('GRENOBLE CITE INTERNATIONALE');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('GIERES PLAINE DES SPORTS');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Tram C');
        $ligne->setCode('C');
        $ligne->setLogo('tramC.png');

        $departure = new Destination;
        $departure->setName('ST-MARTIN-D\'HERES CONDILLAC-UNIVERSITES');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('SEYSSINS LE PRISME');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $manager->persist($ligne);



        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }



}
