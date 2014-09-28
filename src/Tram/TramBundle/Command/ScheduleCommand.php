<?php
namespace Tram\TramBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Agent;
use Tram\TramBundle\Entity\Schedule;

class ScheduleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('tramschedules:load')
            ->setDescription('Load Schedules for Tram')
            ->addArgument(
                'length',
                InputArgument::OPTIONAL,
                'Quelle durée pour la plage horaire'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();
        $length = $input->getArgument('length');

        if(!$length) {
            $length = 6;
        }

        $lignes = $manager->getRepository('TramBundle:Ligne')->findAll();
        $liste_stops = [];

        $stop_repo = $manager->getRepository('TramBundle:Stop');

        $query = $manager->createQuery('DELETE TramBundle:Schedule c');
        $query->execute();

        foreach($lignes as $ligne) {
        /**
         * Fonction qui récupère les données du site de la TAG
         */
        $output->writeln('<info>Ligne ' . $ligne->getName() . '</info>');
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

        $liste_2 = [];

        foreach($liste as $key => $value) {
            $liste_2[$key] = [];
            foreach($liste[$key] as $val) {
                array_push($liste_2[$key], $val);
            }
        }


        foreach($liste_2 as $key => $val) {
            //print_r('key ' . $key);
            //$s = $manager->getRepository('TramBundle:Stop')->findByName($key);

            $s = $manager->getRepository('TramBundle:Stop')->findOneByName($key);

            $timestamp = time()*1000;
            $timestamp_end = $timestamp + $length*3600*1000;

            foreach($val as $key => $code) {
                $output->writeln('<info>Getting schedule for ' . $code . ' ( ' . $s->getName() . ' )</info>');
                $url_time = 'http://83.145.98.139/otp-rest-servlet/ws/transit/stopTimesForStop?agency=SEMx01&extended=true&references=true&routeId=SEM_' . $ligne->getCode() . '&id=' . $code . '&startTime=' . $timestamp . '&endTime=' . $timestamp_end . '&routerId=prod';
                $file = file_get_contents($url_time);
                $json = json_decode($file);

                $direction = $ligne->getDestinations()[$key];

                $times = $json->stopTimes;
                foreach($times as $time)
                {
                    if($time->phase == 'departure') {
                        $schedule = new Schedule;

                        $date = new \DateTime();
                        $date->setTimestamp(($time->time));

                        $schedule->setDate($date);
                        $schedule->setLigne($ligne);
                        $schedule->setStop($s);
                        $schedule->setDestination($direction);

                        $manager->persist($schedule);


                        //$output->writeln('<info>Schedule add ' . $time->time . '</info>');
                    }
                }
                $manager->flush();

            }
        }
        }
        $manager->flush();

        $output->writeln('Done !');
    }
}
