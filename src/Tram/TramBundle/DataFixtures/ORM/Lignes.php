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
        $a = array('A', 'B', 'C', 'D', 'E', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6',
        '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22');
        foreach($a as $l) {
            $url = 'http://83.145.98.139/otp-rest-servlet/ws/transit/routeData?agency=SEMx01&extended=false&references=true&id=SEM_' . $l . '&routerId=prod';
            $file = file_get_contents($url);
            $json = json_decode($file);

            $route = $json->routeData[0]->route;

            $liste_symbol = array(" / ", "/ ", " - ");

            // foreach($liste_symbol as $symbol) {
            //     $names = explode($symbol, $route->routeLongName);
            //
            //     if (count($names) == 2) {
            //         break;
            //     }
            // }


            $ligne = new Ligne;
            $name = 'Ligne ' . $l;
            $ligne->setName($name);
            $ligne->setCode($l);
            $ligne->setColor('#ffffff');
            $ligne->setLogo('logo' . $l . '.png');

            $i = 0;

            echo "Adding " . $name . "\n";

            //foreach($names as $name) {
            for($i = 0 ; $i < 2 ; $i++) {
                $direction = new Direction;

                $direction->setDirection($i);
                $ligne->addDirection($direction);
                $manager->persist($direction);

                $variants = $json->routeData[0]->variants;

                foreach($variants as $variant) {
                    if ($variant->direction == $i) {
                        if(!$direction->getName()) {
                            $direction_name = $variant->trips[0]->headsign;
                            $direction->setName($direction_name);

                            echo $direction_name . "\n";
                        }

                        $destination = new Destination;
                        $destination->setName($variant->trips[0]->headsign);
                        $destination->setDirection($direction);

                        $manager->persist($destination);
                    }
                }

                //$i += 1;
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
