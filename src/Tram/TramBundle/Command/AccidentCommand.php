<?php
namespace Tram\TramBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\DomCrawler\Crawler;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Accident;

use Tram\TramBundle\Monolog\PDOHandler;

class AccidentCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('tramaccident:load')
            ->setDescription('Load Accident for Tram')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get the logger in order to store logging in database
        $logger = $this->getContainer()->get('logger');
        $logger->pushHandler(new PDOHandler(new \PDO('sqlite:logs.sqlite')));

        $logger->info('Lauching Accident command');

        // Get the doctrine Manager to execute request
        $manager = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();

        // Delete all old accidents in order to avoid conflict
        $query = $manager->createQuery('DELETE TramBundle:Accident c');
        $query->execute();

        $html = file_get_contents('http://www.tag.fr/rss_info_trafic.php');

        // Crawler to read html file
        $crawler = new Crawler($html);
        $c = $crawler->filter('rss channel item');

        foreach($c as $t) {
            $child = iterator_to_array($t->childNodes);
            //print_r($t);
            
            $name = trim($child[3]->textContent);
            
            $main = $child[5]->textContent;
            
            $date = trim(strip_tags(explode('<br>', $main)[0]));
            
          
            $description = preg_replace_callback("/(&#[0-9]+;)/", 
                    function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, 
                            strip_tags(explode('<br>', $main)[1])); 
            
            
            $url = $child[7]->textContent;
            $code = explode('/', $url)[4];
                 
            
            $ligne = $manager->getRepository('TramBundle:Ligne')->findOneByCode($code);
            if ($ligne) {
                $output->writeln('<info>Adding accident for ' . $code . '</info>');
                $accident = new Accident;
                $accident->setName($name);
                $accident->setDate($date);
                $accident->setDescription($description);

                $accident->setLigne($ligne);

                $manager->persist($accident);
                $manager->flush();
            }


        }

        $logger->info('End of Accident command');
    }
}
