<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Ligne;

class Lignes extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ligne = new Ligne;
        $ligne->setName('Tram A');
        $ligne->setCode('A');
        $ligne->setLogo('tramA.png');
        $ligne->setDeparture('ECHIROLLES DENIS PAPIN');
        $ligne->setArrival('FONTAINE LA POYA');

        $this->addReference('ligneA', $ligne);

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Tram B');
        $ligne->setCode('B');
        $ligne->setLogo('tramB.png');
        $ligne->setDeparture('GRENOBLE CITE INTERNATIONALE');
        $ligne->setArrival('GIERES PLAINE DES SPORTS');

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Tram C');
        $ligne->setCode('C');
        $ligne->setLogo('tramC.png');
        $ligne->setDeparture('GIERES PLAINE DES SPORTS');
        $ligne->setArrival('SEYSSINS LE PRISME');

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Tram D');
        $ligne->setCode('D');
        $ligne->setLogo('tramD.png');
        $ligne->setDeparture('GIERES PLAINE DES SPORTS');
        $ligne->setArrival('ST-MARTIN-D\'HERES ETIENNE GRAPPE');

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
