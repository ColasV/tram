<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\ScheduleRepository")
 */
class Schedule
{


    /**
     * @var \DateTime
     * @ORM\Id
     * @ORM\Column(name="date", type="string")
     */
    private $date;

    /**
   * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Ligne", inversedBy="schedules")
   * @ORM\Id
   * @ORM\JoinColumn(nullable=false)
   */
   private $ligne;

   /**
  * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Stop")
  * @ORM\Id
  * @ORM\JoinColumn(nullable=false)
  */
  private $stop;

  /**
 * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Destination")
 * @ORM\Id
 * @ORM\JoinColumn(nullable=false)
 */
 private $destination;




    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Schedule
     */
    public function setDate($date)
    {
        $this->date = $date->format('Y-m-d H-i-s');;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return \DateTime::createFromFormat('Y-m-d H-i-s', $this->date);;
    }

    /**
     * Set ligne
     *
     * @param Tram\TramBundle\Entity\Ligne $ligne
     * @return Schedule
     */
    public function setLigne(\Tram\TramBundle\Entity\Ligne $ligne)
    {
        $this->ligne = $ligne;
        return $this;
    }

    /**
     * Get ligne
     *
     * @return Tram\TramBundle\Entity\Ligne
     */
    public function getLigne()
    {
        return $this->ligne;
    }

    /**
     * Set stop
     *
     * @param Tram\TramBundle\Entity\Stop $stop
     * @return Schedule
     */
    public function setStop(\Tram\TramBundle\Entity\Stop $stop)
    {
        $this->stop = $stop;
        return $this;
    }

    /**
     * Get stop
     *
     * @return Tram\TramBundle\Entity\Stop
     */
    public function getStop()
    {
        return $this->stop;
    }

    /**
     * Set destination
     *
     * @param Tram\TramBundle\Entity\Destination $destination
     * @return Schedule
     */
    public function setDestination(\Tram\TramBundle\Entity\Destination $destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * Get destination
     *
     * @return Tram\TramBundle\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }
}
