<?php

namespace Shakyamouni\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="Shakyamouni\AdminBundle\Repository\SubscriptionRepository")
 */
class Subscription
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private $subtitle;

    /**
     * @var integer
     *
     * @ORM\Column(name="percentage", type="integer", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="1")
     */
    private $percentage;

    /**
     * @var string
     *
     * @ORM\Column(name="maxPrice", type="float", nullable=false)
     * @Assert\NotBlank()
     */
    private $maxPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="mediumPrice", type="float", nullable=true)
     */
    private $mediumPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="lowPrice", type="float", nullable=true)
     */
    private $lowPrice;
    
         /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\SiteBundle\Entity\Event", cascade={"persist"})
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $event;
    
     /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\SiteBundle\Entity\ArticleEvent", cascade={"persist"})
     * @ORM\JoinColumn(name="articleevent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $articleevent;
    
    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\UserBundle\Entity\SubscriptionEvent", mappedBy="subscription", cascade={"persist"})
     */
    private $subscriptionEvent;


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
     * @return Subscription
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
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
     * Set subtitle
     *
     * @param string $subtitle
     * @return Subscription
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    
        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string 
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

     /**
     * Set percentage
     *
     * @param integer $percentage
     * @return Subscription
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    
        return $this;
    }

    /**
     * Get percentage
     *
     * @return integer 
     */
    public function getPercentage()
    {
        return $this->percentage;
    }
    
     /**
     * Set event
     *
     * @param \Shakyamouni\SiteBundle\Entity\Event $event
     * @return NewsletterArticle
     */
    public function setEvent(\Shakyamouni\SiteBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Shakyamouni\SiteBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
    
    /**
     * Set articleevent
     *
     * @param \Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevent
     * @return NewsletterArticle
     */
    public function setArticleevent(\Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevent = null)
    {
        $this->articleevent = $articleevent;

        return $this;
    }

    /**
     * Get articleevent
     *
     * @return \Shakyamouni\SiteBundle\Entity\ArticleEvent 
     */
    public function getArticleevent()
    {
        return $this->articleevent;
    }

    /**
     * Set maxPrice
     *
     * @param float $maxPrice
     * @return Subscription
     */
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;
    
        return $this;
    }

    /**
     * Get maxPrice
     *
     * @return float 
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set mediumPrice
     *
     * @param float $mediumPrice
     * @return Subscription
     */
    public function setMediumPrice($mediumPrice)
    {
        $this->mediumPrice = $mediumPrice;
    
        return $this;
    }

    /**
     * Get mediumPrice
     *
     * @return float 
     */
    public function getMediumPrice()
    {
        return $this->mediumPrice;
    }

    /**
     * Set lowPrice
     *
     * @param float $lowPrice
     * @return Subscription
     */
    public function setLowPrice($lowPrice)
    {
        $this->lowPrice = $lowPrice;
    
        return $this;
    }

    /**
     * Get lowPrice
     *
     * @return float 
     */
    public function getLowPrice()
    {
        return $this->lowPrice;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subscriptionEvent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subscriptionEvent
     *
     * @param \Shakyamouni\UserBundle\Entity\SubscriptionEvent $subscriptionEvent
     * @return Subscription
     */
    public function addSubscriptionEvent(\Shakyamouni\UserBundle\Entity\SubscriptionEvent $subscriptionEvent)
    {
        $this->subscriptionEvent[] = $subscriptionEvent;
    
        return $this;
    }

    /**
     * Remove subscriptionEvent
     *
     * @param \Shakyamouni\UserBundle\Entity\SubscriptionEvent $subscriptionEvent
     */
    public function removeSubscriptionEvent(\Shakyamouni\UserBundle\Entity\SubscriptionEvent $subscriptionEvent)
    {
        $this->subscriptionEvent->removeElement($subscriptionEvent);
    }

    /**
     * Get subscriptionEvent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptionEvent()
    {
        return $this->subscriptionEvent;
    }
}
