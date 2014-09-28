<?php
namespace Tram\TramBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\DomCrawler\Crawler;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Accident;

class AccidentCommand extends Command
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
        $manager = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();

        $query = $manager->createQuery('DELETE TramBundle:Accident c');
        $query->execute();

        $html = file_get_contents('http://www.tag.fr/89-infotrafic.htm');

        $crawler = new Crawler($html);

        $c = $crawler->filter('div[id=contenu] ul');


        foreach($c->children() as $t) {
            //print_r($t->childNodes);

            $child = iterator_to_array($t->childNodes);


            // Correspond à l'entête
            //print_r($child[1]);
            $code = trim(explode(':', $child[1]->textContent)[0]);
            // Correspond au corps
            //print_r($child[3]);
            //print_r(iterator_to_array(iterator_to_array(iterator_to_array(iterator_to_array(iterator_to_array($child[3]->childNodes)[1]->childNodes)[0]->childNodes)[1]->childNodes)[3]->childNodes));
            $corps = iterator_to_array(iterator_to_array(iterator_to_array(iterator_to_array(iterator_to_array($child[3]->childNodes)[1]->childNodes)[0]->childNodes)[1]->childNodes)[3]->childNodes);

            $name = trim($corps[1]->textContent);
            $date = trim($corps[3]->textContent);
            $content = trim($corps[5]->textContent);

            $ligne = $manager->getRepository('TramBundle:Ligne')->findOneByCode($code);
            if ($ligne) {
                $output->writeln('<info>Adding accident for ' . $code . '</info>');
                $accident = new Accident;
                $accident->setName($name);
                $accident->setDate($date);
                $accident->setDescription($content);

                $accident->setLigne($ligne);

                $manager->persist($accident);
                $manager->flush();
            }
        }
    }
}
