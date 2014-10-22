<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tram\TramBundle\Entity\Destination
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\DestinationRepository")
 */
class Destination
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Direction", inversedBy="destinations")
     */
    private $direction;

    
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
     * @return Destination
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
     * Set ligne
     *
     * @param \Tram\TramBundle\Entity\Ligne $ligne
     * @return Destination
     */
    public function setLigne(\Tram\TramBundle\Entity\Ligne $ligne)
    {
        $this->ligne = $ligne;

        return $this;
    }

    /**
     * Get ligne
     *
     * @return \Tram\TramBundle\Entity\Ligne
     */
    public function getLigne()
    {
        return $this->ligne;
    }

    /**
     * Set direction
     *
     * @param \Tram\TramBundle\Entity\Direction $direction
     * @return Destination
     */
    public function setDirection(\Tram\TramBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Tram\TramBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }
}