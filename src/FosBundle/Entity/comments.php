<?php

namespace FosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * comments
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class comments
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
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionn", type="text")
     */
    private $descriptionn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Threads", inversedBy="comments") 
     */
    private $threads;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     *
     *
     */
    private $user;

    

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
     * @return comments
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
     * Set descriptionn
     *
     * @param string $descriptionn
     * @return comments
     */
    public function setDescriptionn($descriptionn)
    {
        $this->descriptionn = $descriptionn;

        return $this;
    }

    /**
     * Get descriptionn
     *
     * @return string 
     */
    public function getDescriptionn()
    {
        return $this->descriptionn;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return comments
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
     * Set threads
     *
     * @param \FosBundle\Entity\Threads $threads
     * @return comments
     */
    public function setThreads(\FosBundle\Entity\Threads $threads = null)
    {
        $this->threads = $threads;

        return $this;
    }

    /**
     * Get threads
     *
     * @return \FosBundle\Entity\Threads 
     */
    public function getThreads()
    {
        return $this->threads;
    }

    /**
     * Set user
     *
     * @param \FosBundle\Entity\User $user
     * @return comments
     */
    public function setUser(\FosBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FosBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
