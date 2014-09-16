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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
   * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Ligne", inversedBy="schedules")
   *
   * @ORM\JoinColumn(nullable=false)
   */
   private $ligne;

   /**
  * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Stop")
  *
  * @ORM\JoinColumn(nullable=false)
  */
  private $stop;

  /**
 * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Destination")
 *
 * @ORM\JoinColumn(nullable=false)
 */
 private $destination;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Schedule
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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
