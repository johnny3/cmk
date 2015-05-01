<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Homepage
 *
 * @ORM\Table(name="homepage")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\HomepageRepository")
 */
class Homepage {
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isTitleVisible = false;
        $this->isSubTitleVisible = false;
    }

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
     * @ORM\Column(name="title1", type="string", length=255, nullable=true)
     */
    private $title1;

    /**
     * @var string
     *
     * @ORM\Column(name="body1", type="text", nullable=true)
     */
    private $body1;
    
        /**
     * @var string
     *
     * @ORM\Column(name="title2", type="string", length=255, nullable=true)
     */
    private $title2;

    /**
     * @var string
     *
     * @ORM\Column(name="body2", type="text", nullable=true)
     */
    private $body2;
    
        /**
     * @var string
     *
     * @ORM\Column(name="title3", type="string", length=255, nullable=true)
     */
    private $title3;

    /**
     * @var string
     *
     * @ORM\Column(name="body3", type="text", nullable=true)
     */
    private $body3;

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
     * Set title1
     *
     * @param string $title1
     * @return Homepage
     */
    public function setTitle1($title1)
    {
        $this->title1 = $title1;
    
        return $this;
    }

    /**
     * Get title1
     *
     * @return string 
     */
    public function getTitle1()
    {
        return $this->title1;
    }

    /**
     * Set body1
     *
     * @param string $body1
     * @return Homepage
     */
    public function setBody1($body1)
    {
        $this->body1 = $body1;
    
        return $this;
    }

    /**
     * Get body1
     *
     * @return string 
     */
    public function getBody1()
    {
        return $this->body1;
    }

    /**
     * Set title2
     *
     * @param string $title2
     * @return Homepage
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;
    
        return $this;
    }

    /**
     * Get title2
     *
     * @return string 
     */
    public function getTitle2()
    {
        return $this->title2;
    }

    /**
     * Set body2
     *
     * @param string $body2
     * @return Homepage
     */
    public function setBody2($body2)
    {
        $this->body2 = $body2;
    
        return $this;
    }

    /**
     * Get body2
     *
     * @return string 
     */
    public function getBody2()
    {
        return $this->body2;
    }

    /**
     * Set title3
     *
     * @param string $title3
     * @return Homepage
     */
    public function setTitle3($title3)
    {
        $this->title3 = $title3;
    
        return $this;
    }

    /**
     * Get title3
     *
     * @return string 
     */
    public function getTitle3()
    {
        return $this->title3;
    }

    /**
     * Set body3
     *
     * @param string $body3
     * @return Homepage
     */
    public function setBody3($body3)
    {
        $this->body3 = $body3;
    
        return $this;
    }

    /**
     * Get body3
     *
     * @return string 
     */
    public function getBody3()
    {
        return $this->body3;
    }
}