<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Direction;
use Tram\TramBundle\Entity\Destination;

class Lignes extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $a = array('A', 'B', 'C', 'D', 'E', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6');
        foreach($a as $l) {
            $url = 'http://83.145.98.139/otp-rest-servlet/ws/transit/routeData?agency=SEMx01&extended=false&references=true&id=SEM_' . $l . '&routerId=prod';
            $file = file_get_contents($url);
            $json = json_decode($file);

            $route = $json->routeData[0]->route;
            $names = explode(" / ", $route->routeLongName);

            $ligne = new Ligne;
            $name = 'Ligne ' . $l;
            $ligne->setName($name);
            $ligne->setCode($l);
            $ligne->setLogo('logo' . $l . '.png');

            $i = 0;

            foreach($names as $name) {
                $direction = new Direction;
                $direction->setName($name);
                $direction->setDirection($i);
                $ligne->addDirection($direction);
                $manager->persist($direction);

                $variants = $json->routeData[0]->variants;

                foreach($variants as $variant) {
                    if ($variant->direction == $i) {
                        $destination = new Destination;
                        $destination->setName($variant->trips[0]->headsign);
                        $destination->setDirection($direction);

                        $manager->persist($destination);
                    }
                }

                $i += 1;
            }

            $manager->persist($ligne);

            $manager->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }



}
