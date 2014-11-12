<?php

namespace Tram\TramBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Tram\TramBundle\Entity\Schedule;
use Tram\TramBundle\Entity\Ligne;

class ScheduleUniq
{
    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Schedule) {
            $schedules = $entityManager->getUnitOfWork()->getScheduledEntityInsertions();

            foreach($schedules as $s) {
                if($s instanceof Schedule) {
                    if ($s == $entity) {
                        $entityManager->remove($s);
                        return;
                    }
                }
            }

            $schedules = $entityManager->getRepository('TramBundle:Schedule')->findByStop($entity->getStop());
            foreach($schedules as $s) {
                if($s instanceof Schedule) {
                    if ($s == $entity) {
                        $entityManager->remove($s);
                        $entityManager->flush();
                        return;
                    }
                }
            }


        }





    }
}
