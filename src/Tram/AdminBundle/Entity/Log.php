<?php

namespace Tram\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tram\AdminBundle\Entity\LogRepository")
 */
class Log
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="channel", type="string", length=255)
     */
    private $channel;

    /**
     * @var \DateTime
     * @ORM\Id
     * @ORM\Column(name="time", type="string")
     */
    private $time;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="message", type="text")
     */
    private $message;






    /**
     * Set level
     *
     * @param integer $level
     * @return Log
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set channel
     *
     * @param string $channel
     * @return Log
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set time
     *
     * @param string $time
     * @return Log
     */
    public function setTime($time)
    {
        $this->time = $time->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->time);
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Log
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
