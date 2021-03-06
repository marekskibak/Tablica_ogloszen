<?php
// src/AppBundle/Entity/User.php

namespace FosBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     * 
     * @ORM\OneToMany(targetEntity="Threads", mappedBy="user")
     * 
     * 
     */
    private $threads;

    /**
     * 
     * @ORM\OneToMany(targetEntity="comments", mappedBy="user")
     */
    private $comments;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add threads
     *
     * @param \FosBundle\Entity\Threads $threads
     * @return User
     */
    public function addThread(\FosBundle\Entity\Threads $threads)
    {
        $this->threads[] = $threads;

        return $this;
    }

    /**
     * Remove threads
     *
     * @param \FosBundle\Entity\Threads $threads
     */
    public function removeThread(\FosBundle\Entity\Threads $threads)
    {
        $this->threads->removeElement($threads);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThreads()
    {
        return $this->threads;
    }

    /**
     * Add comments
     *
     * @param \FosBundle\Entity\comments $comments
     * @return User
     */
    public function addComment(\FosBundle\Entity\comments $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \FosBundle\Entity\comments $comments
     */
    public function removeComment(\FosBundle\Entity\comments $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
