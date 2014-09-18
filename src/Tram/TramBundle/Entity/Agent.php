<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\AgentRepository")
 */
class Agent
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
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $last_update;


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
     * Set number
     *
     * @param integer $number
     * @return Agent
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function addNumber()
    {
        $this->number += 1;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set last_update
     *
     * @param \DateTime $lastUpdate
     * @return Agent
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->last_update = $lastUpdate;

        return $this;
    }

    /**
     * Get last_update
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
    * Fonction pour savoir si un agent est encore présent
    */
    public function getPresence()
    {
        $tmp = clone $this->last_update;

        $tmp->modify('+ 15 minute');

        return $tmp > new \DateTime();
    }
}