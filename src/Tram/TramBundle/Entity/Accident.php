<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accident
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\AccidentRepository")
 */
class Accident
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
     * @ORM\Column(name="date", type="text")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
   * @ORM\ManyToOne(targetEntity="Tram\TramBundle\Entity\Ligne", inversedBy="accidents")
   * @ORM\JoinColumn(nullable=false)
   */
   private $ligne;



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
     * @return Accident
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
     * Set description
     *
     * @param string $description
     * @return Accident
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
   * Set ligne
   *
   * @param Tram\TramBundle\Entity\Ligne $ligne
   */
   public function setLigne(Ligne $ligne)
   {
       $this->ligne = $ligne;
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
     * Set date
     *
     * @param text $date
     * @return Accident
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return text 
     */
    public function getDate()
    {
        return $this->date;
    }
}