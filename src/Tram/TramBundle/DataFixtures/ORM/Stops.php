<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Agent;
use Tram\TramBundle\Entity\Schedule;

class Stops extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lignes = $manager->getRepository('TramBundle:Ligne')->findAll();
        $liste_stops = [];

        $stop_repo = $manager->getRepository('TramBundle:Stop');

        foreach($lignes as $ligne) {
            /**
             * Fonction qui récupère les données du site de la TAG
             */
            $url = 'http://83.145.98.139/otp-rest-servlet/ws/transit/routeData?agency=SEMx01&extended=true&references=true&id=SEM_' . $ligne->getCode() . '&routerId=prod';
            echo $url;
            $file = file_get_contents($url);

            $json = json_decode($file);

            $variants = $json->routeData[0]->variants;

            $stops = $json->routeData[0]->stops;
            $liste = [];

            foreach ($variants as $variant) {
            	foreach($variant->stops as $stop) {
            		if(!array_key_exists($stop->name, $liste)) {
            			$liste[$stop->name] = [];
                        $liste[$stop->name]['code'] = [];
                        $coord = [];
                        array_push($coord, $stop->lat);
                        array_push($coord, $stop->lon);
                        $liste[$stop->name]['coord'] = $coord;
            		}
                    print_r($stop->name);
                    print_r($liste[$stop->name]);
            		array_push($liste[$stop->name]['code'], $stop->id->id);
            		$liste[$stop->name]['code'] = array_unique($liste[$stop->name]['code']);
            	}
            }

            $liste_2 = [];

            foreach($liste as $key => $value) {
            	$liste_2[$key] = [];
            	$liste_2[$key]['code'] = [];
                $liste_2[$key]['coord'] = $value['coord'];

                foreach($liste[$key]['code'] as $val) {
            		array_push($liste_2[$key]['code'], $val);
            	}
            }

            //print_r($liste_2);

            foreach($liste_2 as $key => $val) {
                $s = null;

                if(array_key_exists($key, $liste_stops)) {
                    $s = $liste_stops[$key];
                } else {
                    $s = $manager->getRepository('TramBundle:Stop')->findOneByName($key);
                }

                if(!$s) {
                    $s = new Stop();
                    $s->setName($key);
                    $s->setCode($val['code'][0]);
                    $s->setLat($val['coord'][0]);
                    $s->setLng($val['coord'][1]);
                    $liste_stops[$key] = $s;
                }

                $ligne->addStop($s);
                $manager->persist($s);
                $manager->flush();
            }
        }
    }


    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
