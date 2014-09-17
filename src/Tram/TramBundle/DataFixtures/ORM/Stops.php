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

        //$ligne_2 = $manager->getRepository('TramBundle:Ligne')->find(2);

        $stop_repo = $manager->getRepository('TramBundle:Stop');

        foreach($lignes as $ligne) {
        /**
         * Fonction qui récupère les données du site de la TAG
         */
        $url = 'http://83.145.98.139/otp-rest-servlet/ws/transit/routeData?agency=SEMx01&extended=true&references=true&id=SEM_' . $ligne->getCode() . '&routerId=prod';
        $file = file_get_contents($url);

        $json = json_decode($file);

        $variants = $json->routeData[0]->variants;

        $stops = $json->routeData[0]->stops;
        $liste = [];

        foreach ($variants as $variant) {
        	foreach($variant->stops as $stop) {
        		if(!array_key_exists($stop->name, $liste)) {
        			$liste[$stop->name] = [];
        		}
        		array_push($liste[$stop->name], $stop->id->id);
        		$liste[$stop->name] = array_unique($liste[$stop->name]);
        	}
        }

        foreach($liste as $key => $val) {
            print_r('key ' . $key);
            //$s = $manager->getRepository('TramBundle:Stop')->findByName($key);

            $s = null;
            if(array_key_exists($key, $liste_stops)) {
                $s = $liste_stops[$key];
            }

            if(!$s) {
                $s = new Stop;
                $s->setName($key);
                $s->setCode($val[0]);
                $s->setLat('1.0');
                $s->setLng('1.0');
                $liste_stops[$key] = $s;
            }

            $ligne->addStop($s);
            $manager->persist($s);
            $manager->flush();

            $timestamp = time()*1000;
            $timestamp_end = $timestamp + 0.5*3600*1000;

            foreach($val as $key => $code) {
                echo "Getting schedule for $code \n";
        		$url_time = 'http://83.145.98.139/otp-rest-servlet/ws/transit/stopTimesForStop?agency=SEMx01&extended=true&references=true&routeId=SEM_' . $ligne->getCode() . '&id=' . $code . '&startTime=' . $timestamp . '&endTime=' . $timestamp_end . '&routerId=prod';
        		$file = file_get_contents($url_time);
        		$json = json_decode($file);

                $direction = $ligne->getDestinations()[$key];

        		$times = $json->stopTimes;
        		foreach($times as $time)
        		{
                    echo "Creating schedule $time->time\n";
                    $schedule = new Schedule;

                    $date = new \DateTime();
                    $date->setTimestamp(($time->time));

                    $schedule->setDate($date);
                    $schedule->setLigne($ligne);
                    $schedule->setStop($s);
                    $schedule->setDestination($direction);

                    $manager->persist($schedule);
                    $manager->flush();

                    echo "Schedule add\n";
        		}
            }
        }
        }
        // $stop = new Stop;
        // $stop->setName('Tutu');
        // $stop->setCode('Lol');
        // $stop->setLat('1.0');
        // $stop->setLng('1.0');
        //
        // $ligne_2->addStop($stop);
        //
        // $manager->persist($stop);
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
