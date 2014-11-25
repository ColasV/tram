<?php

namespace Tram\TramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Ligne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\TramBundle\Entity\LigneRepository")
 */
class Ligne
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
    * @var string
    *
    * @ORM\Column(name="color", type="string", length=255)
    */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity="Tram\TramBundle\Entity\Direction", cascade={"persist"}, mappedBy="ligne")
     */
    private $directions;

    /**
    * @ORM\ManyToMany(targetEntity="Tram\TramBundle\Entity\Stop", cascade={"persist"}, mappedBy="lignes")
    */
    private $stops;

    /**
     * @ORM\OneToMany(targetEntity="Tram\TramBundle\Entity\Schedule", mappedBy="ligne")
     */
    private $schedules;


  /**
   * @ORM\OneToMany(targetEntity="Tram\TramBundle\Entity\Accident", mappedBy="ligne")
   */
  private $accidents;



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
     * @return Ligne
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
     * @return Ligne
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
     * Set logo
     *
     * @param string $logo
     * @return Ligne
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set departure
     *
     * @param string $departure
     * @return Ligne
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return string
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set arrival
     *
     * @param string $arrival
     * @return Ligne
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return string
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    public function __construct()
    {
        $this->stops = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
    * Add stop
    *
    * @param Tram\TramBundle\Entity\Stop $stop
    */
    public function addStop(Stop $stop) // addCategorie sans « s » !
    {
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau, avec la syntaxe []
        $this->stops[] = $stop;
        $stop->addLigne($this);
    }

    /**
     * Remove stop
     *
     * @param Tram\TramBundle\Entity\Stop $stops
     */
     public function removeStop(Stop $stop) // removeCategorie sans « s » !
     {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->stops->removeElement($stop);
     }

     /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection
    */
    public function getStops() // Notez le « s », on récupère une liste de catégories ici !
    {
        return $this->stops;
    }

    public function getLogourl()
    {
        return '/images/' . $this->logo;
    }

    /**
     * Add accidents
     *
     * @param Tram\TramBundle\Entity\Accident $accidents
     * @return Ligne
     */
    public function addAccident(\Tram\TramBundle\Entity\Accident $accidents)
    {
        $this->accidents[] = $accidents;
        return $this;
    }

    /**
     * Remove accidents
     *
     * @param Tram\TramBundle\Entity\Accident $accidents
     */
    public function removeAccident(\Tram\TramBundle\Entity\Accident $accidents)
    {
        $this->accidents->removeElement($accidents);
    }

    /**
     * Get accidents
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAccidents()
    {
        return $this->accidents;
    }

    /**
     * Add schedules
     *
     * @param Tram\TramBundle\Entity\Schedule $schedules
     * @return Ligne
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
     *
     */
     public function getHoraires(Stop $stop, Direction $destination, $taille = 5)
     {
        $date = new \DateTime();

        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('stop', $stop));
        $criteria->andWhere(Criteria::expr()->eq('direction', $destination));
        $criteria->andWhere(Criteria::expr()->gte('date', $date->format('Y-m-d H-i-s')));
        $criteria->setMaxResults($taille);

        $result = $this->schedules->matching($criteria);

        return $result;
     }

     public function hasHoraires(Stop $stop, Direction $destination)
     {
         $date = new \DateTime();

         $criteria = Criteria::create();
         $criteria->where(Criteria::expr()->eq('stop', $stop));
         $criteria->andWhere(Criteria::expr()->eq('direction', $destination));
         $criteria->andWhere(Criteria::expr()->gte('date', $date->format('Y-m-d H-i-s')));

         $result = $this->schedules->matching($criteria);

         if ($result->isEmpty()) {
             return false;
         } else {
             return true;
         }
     }

     public function isAvailable(Stop $stop)
     {
         $result = false;

         foreach($this->directions as $direction) {
            if(($this->hasHoraires($stop, $direction))) {
                $result = true;
            }
         }

         return $result;
     }


    /**
     * Add destinations
     *
     * @param \Tram\TramBundle\Entity\Destination $destinations
     * @return Ligne
     */
    public function addDirection(\Tram\TramBundle\Entity\Direction $directions)
    {
        $this->directions[] = $directions;
        $directions->setLigne($this);
        return $this;
    }

    /**
     * Remove destinations
     *
     * @param \Tram\TramBundle\Entity\Destination $destinations
     */
    public function removeDirection(\Tram\TramBundle\Entity\Direction $destinations)
    {
        $this->directions->removeElement($destinations);
    }

    /**
     * Get destinations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirections()
    {
        return $this->directions;
    }


    /**
     * Return the direction for a ligne based on his id
     */
    public function getDirectionById($id) {
        foreach($this->directions as $direction) {
            if ($direction->getDirection() == $id) {
                return $direction;
            }
        }
    }

    /**
     * Return true there is one (or more) accident
     * Return false if there is no accident
     *
     */
    public function getHasAccident() {
        if (!$this->accidents->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }




    /**
     * Set color
     *
     * @param string $color
     * @return Ligne
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
