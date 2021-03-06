<?php
namespace Tram\TramBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Agent;
use Tram\TramBundle\Entity\Schedule;

use Tram\TramBundle\Monolog\PDOHandler;

class ScheduleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('tram:schedules:load')
            ->setDescription('Load Schedules for Tram')
            ->addArgument(
                'length',
                InputArgument::OPTIONAL,
                'Quelle durée pour la plage horaire'
            )
            ->addArgument(
                'ligne',
                InputArgument::OPTIONAL,
                'Importer une ligne spécifique'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '1024M');

        // Get the logger in order to store logging in database
        $logger = $this->getContainer()->get('logger');
        $pdo = $this->getContainer()->get('database_connection')->getWrappedConnection();
        $logger->pushHandler(new PDOHandler($pdo));

        // Get Argument from the input line
        // Standard length is 6 hours
        $length = $input->getArgument('length');
        if(!$length) {
            $length = 6;
        }

        // Get the Doctrine Manager to execute request
        $manager = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();

        $ligne = $input->getArgument('ligne');
        if($ligne) {
            $output->writeln('<info>Specific mode ' . $ligne . ' </info>');
            $lignes = $manager->getRepository('TramBundle:Ligne')->findByCode($ligne);
        } else {
            $output->writeln('<info>Total mode</info>');
            $lignes = $manager->getRepository('TramBundle:Ligne')->findAll();
        }

        if(!$lignes) {
            $output->writeln('<error>Variable $lignes vide</error>');
        }

        $output->writeln('<info>Downloading schedules for ' . $length  . ' hours</info>');
        $logger->info('schedule command length ' . $length);

        // The algorithm to extract schedule from tag website
        $liste_stops = [];

        $stop_repo = $manager->getRepository('TramBundle:Stop');

        // Delete old schedules
        $date = new \DateTime();
        $query = $manager->createQuery('DELETE TramBundle:Schedule c WHERE c.date < :date')
                            ->setParameter('date', $date->format('Y-m-d H-i-s'));
        $query->execute();

        foreach($lignes as $ligne) {
            $output->writeln('<info>Ligne ' . $ligne->getName() . '</info>');
            $logger->info('schedule command ligne ' . $ligne->getName());
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
                $s = $manager->getRepository('TramBundle:Stop')->findOneByName($key);

                $timestamp = time()*1000;
                $timestamp_end = $timestamp + $length*3600*1000;

                $directionId = 0;
                $output->writeln('Key ' . $key );
                foreach($val as $key => $code) {
                    $output->writeln('<info>Getting schedule for ' . $code . '</info>');
                    $url_time = 'http://83.145.98.139/otp-rest-servlet/ws/transit/stopTimesForStop?agency=SEMx01&extended=true&references=true&routeId=SEM_' . $ligne->getCode() . '&id=' . $code . '&startTime=' . $timestamp . '&endTime=' . $timestamp_end . '&routerId=prod';

                    $output->writeln($url_time);

                    $file = file_get_contents($url_time);
                    $json = json_decode($file);

                    $times = $json->stopTimes;

                    foreach($times as $time)
                    {
                        if($time->phase == 'departure') {
                            /* On récupère en base la direction associé */
                            $directionId = $time->trip->directionId;
                            $direction = $ligne->getDirectionById($directionId);

                            /* On s'en fout de la direction, ce qu'on veut c'est le bon ordre des directions */
                            var_dump(str_replace('-',' ',$time->direction));
                            var_dump(str_replace('-',' ',$direction->getName()));

                            $schedule = new Schedule;

                            $date = new \DateTime();
                            $date->setTimestamp(($time->time));
                            $output->writeln($time->time);

                            $schedule->setDate($date);
                            $schedule->setLigne($ligne);
                            $schedule->setStop($s);
                            $schedule->setDirection($direction);

                            $manager->persist($schedule);
                        }
                    }
                    $manager->flush();
                    $file = null;
                }
            }
        }
        $manager->flush();

        $logger->info('schedule command end successfully');
        $output->writeln('Done !');
    }
}
