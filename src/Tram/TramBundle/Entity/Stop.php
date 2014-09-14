<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\StopRepository")
 */
class Stop
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float")
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float")
     */
    private $lng;

    /**
    * @ORM\ManyToMany(targetEntity="Tram\TramBundle\Entity\Ligne", cascade={"persist"}, inversedBy="stops")
    */
    private $lignes;

    /**
     * @ORM\OneToOne(targetEntity="Tram\TramBundle\Entity\Agent")
     */
    private $agent;


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
     * Set name
     *
     * @param string $name
     * @return Stop
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Stop
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Stop
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Stop
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }
    public function __construct()
    {
        $this->schedules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schedules
     *
     * @param Tram\TramBundle\Entity\Schedule $schedules
     * @return Stop
     */
    public function addSchedule(\Tram\TramBundle\Entity\Schedule $schedules)
    {
        $this->schedules[] = $schedules;
        return $this;
    }

    /**
     * Remove schedules
     *
     * @param Tram\TramBundle\Entity\Schedule $schedules
     */
    public function removeSchedule(\Tram\TramBundle\Entity\Schedule $schedules)
    {
        $this->schedules->removeElement($schedules);
    }

    /**
     * Get schedules
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * Add lignes
     *
     * @param Tram\TramBundle\Entity\Ligne $lignes
     * @return Stop
     */
    public function addLigne(\Tram\TramBundle\Entity\Ligne $lignes)
    {
        $this->lignes[] = $lignes;
        return $this;
    }

    /**
     * Remove lignes
     *
     * @param Tram\TramBundle\Entity\Ligne $lignes
     */
    public function removeLigne(\Tram\TramBundle\Entity\Ligne $lignes)
    {
        $this->lignes->removeElement($lignes);
    }

    /**
     * Get lignes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * Set controlleur
     *
     * @param \Tram\TramBundle\Entity\Controlleur $controlleur
     * @return Stop
     */
    public function setAgent(\Tram\TramBundle\Entity\Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get controlleur
     *
     * @return \Tram\TramBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }


    public function getPresence()
    {
        if ($this->agent) {
            return $this->agent->getPresence();
        } else {
            return false;
        }
    }


}
