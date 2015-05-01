<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="articleevent")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\ArticleEventRepository")
 */
class ArticleEvent {

    /**
     * Constructor
     */
//    public function __construct()
//    {
//        $this->isVisible = true;
//    }
    
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
     * @ORM\Column(length=255, unique=true)
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
     * @ORM\Column(name="body", type="text")
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
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\Event", cascade={"persist"}, inversedBy="articleevents")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $event;
    
    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\AdminBundle\Entity\NewsletterArticle", mappedBy="articleevent")
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
        return $this->event->getTitle() . ' / ' . $this->title . ' ' . $this->eventDateStart->format('d-m-Y') . ' -> ' . $this->eventDateEnd->format('d-m-Y');
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ArticleEvent
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
     * @return ArticleEvent
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
     * Set slug
     *
     * @param string $slug
     * @return ArticleEvent
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
     * @return ArticleEvent
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
     * @return ArticleEvent
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
     * @return ArticleEvent
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
     * @return ArticleEvent
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
     * @return ArticleEvent
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
     * Set pictureSize
     *
     * @param \Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize
     * @return ArticleEvent
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
     * @return ArticleEvent
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
     * Set event
     *
     * @param \Shakyamouni\SiteBundle\Entity\Event $event
     * @return ArticleEvent
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
     * Constructor
     */
    public function __construct()
    {
        $this->newsletterarticles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add newsletterarticles
     *
     * @param \Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles
     * @return ArticleEvent
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