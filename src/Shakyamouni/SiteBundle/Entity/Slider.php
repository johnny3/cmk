<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shakyamouni\SiteBundle\Entity\Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\SliderRepository")
 */
class Slider {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isCaption = false;
    }
    
    /**
     * @var integer $id
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
     * @Assert\Length(min="1")
     */
    private $title;

    /**
     * @var string $subtitle
     * @ORM\Column(name="subtitle", type="string",length=255, nullable=true)
     * @Assert\Length(min="1")
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Assert\File(maxSize="2M")
     */
    public $file;

    /**
     * @var integer $position
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\SiteBundle\Entity\Event", cascade={"persist"})
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $event;

    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\SiteBundle\Entity\Article", cascade={"persist"})
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $article;

    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategory", cascade={"persist"})
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $subcategory;

    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\SiteBundle\Entity\ArticleEvent", cascade={"persist"})
     * @ORM\JoinColumn(name="articleevent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $articleevent;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_caption", type="boolean", nullable=true)
     */
    private $isCaption;

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
     * Set subtitle
     *
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
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
     * Set picture
     *
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
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
     * Set position
     *
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
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
     * Set event
     *
     * @param \Shakyamouni\SiteBundle\Entity\Event $event
     * @return Slider
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
     * Set article
     *
     * @param \Shakyamouni\SiteBundle\Entity\Article $article
     * @return Slider
     */
    public function setArticle(\Shakyamouni\SiteBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Shakyamouni\SiteBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
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
        return 'uploads/carrousel';
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
     * Set isCaption
     *
     * @param boolean $isCaption
     * @return Slider
     */
    public function setIsCaption($isCaption)
    {
        $this->isCaption = $isCaption;

        return $this;
    }

    /**
     * Get isCaption
     *
     * @return boolean 
     */
    public function getIsCaption()
    {
        return $this->isCaption;
    }

    /**
     * Set articleevent
     *
     * @param \Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevent
     * @return Slider
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
     * Set subcategory
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategory $subcategory
     * @return Slider
     */
    public function setSubcategory(\Shakyamouni\MenuBundle\Entity\SubCategory $subcategory = null)
    {
        $this->subcategory = $subcategory;
    
        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \Shakyamouni\MenuBundle\Entity\SubCategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }
}