<?php

namespace FosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorieskids
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Categorieskids
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
     * @var
     * 
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="Categorieskids")
     * 
     */
    private $categories;
    
    
    
    
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
     * Set categories
     *
     * @param \FosBundle\Entity\Categories $categories
     * @return Categorieskids
     */
    public function setCategories(\FosBundle\Entity\Categories $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \FosBundle\Entity\Categories 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
