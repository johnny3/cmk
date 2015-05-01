<?php

namespace Shakyamouni\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="Shakyamouni\AdminBundle\Repository\NewsletterRepository")
 */
class Newsletter
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;
    
     /**
     * @var string $title
     * @ORM\Column(name="title", type="string",length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\AdminBundle\Entity\Calendar", inversedBy="newsletters")
     * @ORM\JoinColumn(name="pm_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $pm;
    
    /**
     * @var string
     *
     * @ORM\Column(name="is_pm_uploadable", type="boolean", nullable=true)
     */
    private $isPmUploadable;
    
     /**
     * @var string
     *
     * @ORM\Column(name="mailObject", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $mailObject;
    
     /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $sentence;
    
         /**
     * @var string $manualTitle
     * @ORM\Column(name="manualTitle", type="string",length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $manualTitle;
    
     /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\AdminBundle\Entity\NewsletterArticle", mappedBy="newsletter", cascade={"persist"})
     */
    private $newsletterarticles;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
        return $this->title;
    }
    
    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
     /**
     * Set slug
     *
     * @param string $slug
     * @return Slider
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
     /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->newsletterarticles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->title = 'newsletter-' . date('d-m-Y');
    }
    
    /**
     * Add newsletterarticles
     *
     * @param \Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles
     * @return Newsletter
     */
    public function addNewsletterarticle(\Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticle)
    {
        $this->newsletterarticles[] = $newsletterarticle;
        $newsletterarticle->setNewsletter($this);
        return $this;
    }

    /**
     * Remove newsletterarticles
     *
     * @param \Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles
     */
    public function removeNewsletterarticle(\Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles)
    {
        $this->newsletterarticles->removeElement($newsletterarticles);
    }

    /**
     * Get newsletterarticles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsletterarticles()
    {
        return $this->newsletterarticles;
    }

    /**
     * Set pm
     *
     * @param \Shakyamouni\AdminBundle\Entity\Calendar $pm
     * @return Newsletter
     */
    public function setPm(\Shakyamouni\AdminBundle\Entity\Calendar $pm)
    {
        $this->pm = $pm;
    
        return $this;
    }

    /**
     * Get pm
     *
     * @return \Shakyamouni\AdminBundle\Entity\Calendar 
     */
    public function getPm()
    {
        return $this->pm;
    }

    /**
     * Set mailObject
     *
     * @param string $mailObject
     * @return Newsletter
     */
    public function setMailObject($mailObject)
    {
        $this->mailObject = $mailObject;
    
        return $this;
    }

    /**
     * Get mailObject
     *
     * @return string 
     */
    public function getMailObject()
    {
        return $this->mailObject;
    }

    /**
     * Set sentence
     *
     * @param string $sentence
     * @return Newsletter
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;
    
        return $this;
    }

    /**
     * Get sentence
     *
     * @return string 
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set manualTitle
     *
     * @param string $manualTitle
     * @return Newsletter
     */
    public function setManualTitle($manualTitle)
    {
        $this->manualTitle = $manualTitle;
    
        return $this;
    }

    /**
     * Get manualTitle
     *
     * @return string 
     */
    public function getManualTitle()
    {
        return $this->manualTitle;
    }

    /**
     * Set isPmUploadable
     *
     * @param boolean $isPmUploadable
     * @return Newsletter
     */
    public function setIsPmUploadable($isPmUploadable)
    {
        $this->isPmUploadable = $isPmUploadable;
    
        return $this;
    }

    /**
     * Get isPmUploadable
     *
     * @return boolean 
     */
    public function getIsPmUploadable()
    {
        return $this->isPmUploadable;
    }
}