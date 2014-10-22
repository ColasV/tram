<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tram\TramBundle\Entity\Direction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\DirectionRepository")
 */
class Direction
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
   * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Ligne", inversedBy="directions")
   * @ORM\JoinColumn(nullable=false)
   */
   private $ligne;

   /**
    * @ORM\OneToMany(targetEntity="Tram\TramBundle\Entity\Destination", mappedBy="direction")
    */
   private $destinations;

   /**
   * @var integer direction
   *
   * @ORM\Column(name="direction", type="integer")
   */
   private $direction;

    private $hash;


    public function __construct()
    {
        $this->hash = uniqid();
    }

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

    public function getHash()
    {
        if(empty($this->hash)) {
            $this->hash = uniqid();
        }
        return $this->hash;
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
     * Add destinations
     *
     * @param \Tram\TramBundle\Entity\Destination $destinations
     * @return Direction
     */
    public function addDestination(\Tram\TramBundle\Entity\Destination $destinations)
    {
        $this->destinations[] = $destinations;

        return $this;
    }

    /**
     * Remove destinations
     *
     * @param \Tram\TramBundle\Entity\Destination $destinations
     */
    public function removeDestination(\Tram\TramBundle\Entity\Destination $destinations)
    {
        $this->destinations->removeElement($destinations);
    }

    /**
     * Get destinations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * Set direction
     *
     * @param integer $direction
     * @return Direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    
        return $this;
    }

    /**
     * Get direction
     *
     * @return integer 
     */
    public function getDirection()
    {
        return $this->direction;
    }
}