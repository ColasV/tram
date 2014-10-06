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
        $departure->setName('FONTAINE LA POYA');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('ECHIROLLES DENIS PAPIN');
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

        $ligne = new Ligne;
        $ligne->setName('Tram D');
        $ligne->setCode('D');
        $ligne->setLogo('tramD.png');

        $departure = new Destination;
        $departure->setName('SAINT-MARTIN-D\'HERES ETIENNE GRAPPE');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('SAINT-MARTIN-D\'HERES LES TAILLEES - UNIVERSITES');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Tram E');
        $ligne->setCode('E');
        $ligne->setLogo('tramE.png');

        $departure = new Destination;
        $departure->setName('SAINT-MARTIN-LE-VINOUX HOTEL DE VILLE');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('GRENOBLE LOUISE MICHEL');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $manager->persist($ligne);

        $ligne = new Ligne;
        $ligne->setName('Bus C1');
        $ligne->setCode('C1');
        $ligne->setLogo('busC1.png');

        $departure = new Destination;
        $departure->setName('GRENOBLE Cité Jean Macé');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('MEYLAN Maupertuis');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $manager->persist($ligne);
        
        $ligne = new Ligne;
        $ligne->setName('Bus C2');
        $ligne->setCode('C2');
        $ligne->setLogo('busC2.png');

        $departure = new Destination;
        $departure->setName('GRENOBLE Louise Michel');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('CLAIX Pont Rouge');
        $ligne->addDestination($arrival);
        $manager->persist($arrival);

        $manager->persist($ligne);
        
        $ligne = new Ligne;
        $ligne->setName('Bus C5');
        $ligne->setCode('C5');
        $ligne->setLogo('busC5.png');

        $departure = new Destination;
        $departure->setName('GRENOBLE Palais de Justice');
        $ligne->addDestination($departure);
        $manager->persist($departure);

        $arrival = new Destination;
        $arrival->setName('GIÈRES Universités - Biologie');
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
