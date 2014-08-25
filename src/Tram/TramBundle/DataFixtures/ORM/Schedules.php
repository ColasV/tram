<?php

namespace Tram\TramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Ligne;
use Tram\TramBundle\Entity\Schedule;

class Schedules extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ligne = $manager->getRepository('TramBundle:Ligne')->find(1);
        $stop = $manager->getRepository('TramBundle:Stop')->find(1);
        $departure = $manager->getRepository('TramBundle:Destination')->find(1);
        $arrival = $manager->getRepository('TramBundle:Destination')->find(2);

        $schedule = new Schedule;
        $schedule->setDate(new \DateTime());
        $schedule->setLigne($ligne);
        $schedule->setStop($stop);
        $schedule->setDestination($departure);

        $manager->persist($schedule);

        $schedule = new Schedule;
        $schedule->setDate(new \DateTime());
        $schedule->setLigne($ligne);
        $schedule->setStop($stop);
        $schedule->setDestination($arrival);

        $manager->persist($schedule);

        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}
