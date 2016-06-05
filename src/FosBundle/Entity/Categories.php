<?php

namespace FosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Categories
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
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @var integer
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="Threads", mappedBy="category")
     *
     *
     */
     private $threads;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Categorieskids", mappedBy="Categories")
     *
     */
    private $Categorieskids;


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
     * @return Categories
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
     * Set number
     *
     * @param integer $number
     * @return Categories
     */
    public function setNumber($number)
    {
        $this->number = $number;

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
     * Constructor
     */
    public function __construct()
    {
        $this->threads = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add threads
     *
     * @param \FosBundle\Entity\Threads $threads
     * @return Categories
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
     * Add Categorieskids
     *
     * @param \FosBundle\Entity\Categorieskids $categorieskids
     * @return Categories
     */
    public function addCategorieskid(\FosBundle\Entity\Categorieskids $categorieskids)
    {
        $this->Categorieskids[] = $categorieskids;

        return $this;
    }

    /**
     * Remove Categorieskids
     *
     * @param \FosBundle\Entity\Categorieskids $categorieskids
     */
    public function removeCategorieskid(\FosBundle\Entity\Categorieskids $categorieskids)
    {
        $this->Categorieskids->removeElement($categorieskids);
    }

    /**
     * Get Categorieskids
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorieskids()
    {
        return $this->Categorieskids;
    }
}
