<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\EventRepository")
 */
class Event {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articleevents = new \Doctrine\Common\Collections\ArrayCollection();
    //    $this->isVisible = true;
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
     * @ORM\Column(name="event_date_start", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $eventDateStart;
    
    /**
     * @ORM\Column(name="event_date_end", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $eventDateEnd;

    /**
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true, nullable=true)
     */
    private $slug;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible", type="boolean", nullable=true)
     */
    private $isVisible;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
        
    /**
     * @var string
     *
     * @ORM\Column(name="chapo", type="text")
     */
    private $chapo;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Assert\File(maxSize="2M")
     */
    public $file;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_picture", type="boolean", nullable=true)
     */
    private $isPicture;
        
    /**
     * @var string
     *
     * @ORM\Column(name="reservation_link", type="string", length=255, nullable=true)
     */
    private $reservationLink;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\PictureSize")
     * @ORM\JoinColumn(name="picture_size_id", referencedColumnName="id", nullable=true)
     */
    private $pictureSize;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategoryEvent", inversedBy="events")
     * @ORM\JoinColumn(name="subcategory_event_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $subCategoryEvent;

    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\SiteBundle\Entity\ArticleEvent", mappedBy="event")
     */
    private $articleevents;
    
   /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\AdminBundle\Entity\NewsletterArticle", mappedBy="event")
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
        return $this->title . ' ' . $this->eventDateStart->format('d-m-Y') . ' -> ' . $this->eventDateEnd->format('d-m-Y');
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Event
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Event
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get eventDateStart
     *
     * @return \DateTime 
     */
    public function getEventDateStart()
    {
        return $this->eventDateStart;
    }

    /**
     * Set eventDateStart
     *
     * @param \DateTime $eventDateStart
     * @return Event
     */
    public function setEventDateStart($eventDateStart)
    {
        $this->eventDateStart = $eventDateStart;

        return $this;
    }
    
    /**
     * Get eventDateEnd
     *
     * @return \DateTime 
     */
    public function getEventDateEnd()
    {
        return $this->eventDateEnd;
    }

    /**
     * Set eventDateEnd
     *
     * @param \DateTime $eventDateEnd
     * @return Event
     */
    public function setEventDateEnd($eventDateEnd)
    {
        $this->eventDateEnd = $eventDateEnd;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Event
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
     * @return Event
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
     * Set body
     *
     * @param string $body
     * @return Event
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * Set chapo
     *
     * @param string $chapo
     * @return Event
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;

        return $this;
    }

    /**
     * Get chapo
     *
     * @return string 
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Event
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return Event
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set subCategoryEvent
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategoryEvent $subCategoryEvent
     * @return Event
     */
    public function setSubCategoryEvent(\Shakyamouni\MenuBundle\Entity\SubCategoryEvent $subCategoryEvent = null)
    {
        $this->subCategoryEvent = $subCategoryEvent;

        return $this;
    }

    /**
     * Get subCategoryEvent
     *
     * @return \Shakyamouni\MenuBundle\Entity\SubCategoryEvent 
     */
    public function getSubCategoryEvent()
    {
        return $this->subCategoryEvent;
    }

    /**
     * Set pictureSize
     *
     * @param \Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize
     * @return Event
     */
    public function setPictureSize(\Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize)
    {
        $this->pictureSize = $pictureSize;

        return $this;
    }

    /**
     * Get pictureSize
     *
     * @return \Shakyamouni\SiteBundle\Entity\PictureSize 
     */
    public function getPictureSize()
    {
        return $this->pictureSize;
    }

    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir() . '/' . $this->picture;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire dans lequel sauvegarder les photos de profil
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads';
    }

    public function uploadProfilePicture()
    {
        // Nous utilisons le nom de fichier original, donc il est dans la pratique
        // nécessaire de le nettoyer pour éviter les problèmes de sécurité
        // move copie le fichier présent chez le client dans le répertoire indiqué.
        $securedFileName = sha1(uniqid(mt_rand(), true). $this->file->getClientOriginalName() * microtime(false)).'.'.$this->file->guessExtension();
        
        $this->file->move($this->getUploadRootDir(), $securedFileName);

        // On sauvegarde le nom de fichier
        $this->picture = $securedFileName;

        // La propriété file ne servira plus
        $this->file = null;
    }

    /**
     * Set isPicture
     *
     * @param boolean $isPicture
     * @return Event
     */
    public function setIsPicture($isPicture)
    {
        $this->isPicture = $isPicture;

        return $this;
    }

    /**
     * Get isPicture
     *
     * @return boolean 
     */
    public function getIsPicture()
    {
        return $this->isPicture;
    }

    /**
     * Add articleevents
     *
     * @param \Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevents
     * @return Event
     */
    public function addArticleevent(\Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevents)
    {
        $this->articleevents[] = $articleevents;
        $articleevents->setEvent($this);
        return $this;
    }

    /**
     * Remove articleevents
     *
     * @param \Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevents
     */
    public function removeArticleevent(\Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevents)
    {
        $this->articleevents->removeElement($articleevents);
    }

    /**
     * Get articleevents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticleevents()
    {
        return $this->articleevents;
    }
       
    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     * @return SubCategory
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean 
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }
    
     /**
     * Set reservation link
     *
     * @param string $reservationLink
     * @return Info
     */
    public function setReservationLink($reservationLink)
    {
        $this->reservationLink = $reservationLink;

        return $this;
    }

    /**
     * Get reservation link
     *
     * @return string 
     */
    public function getReservationLink()
    {
        return $this->reservationLink;
    }

    /**
     * Add newsletterarticles
     *
     * @param \Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles
     * @return Event
     */
    public function addNewsletterarticle(\Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles)
    {
        $this->newsletterarticles[] = $newsletterarticles;
    
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
}