<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\PictureRepository")
 */
class Picture {

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
     * @ORM\Column(name="picture", type="string", length=255)
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255)
     */
    private $subtitle;

    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategory", cascade={"persist"})
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $subCategory;

    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategoryEvent", cascade={"persist"})
     * @ORM\JoinColumn(name="subcategoryevent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $subCategoryEvent;
    
    /**
     * @ORM\OneToOne(targetEntity="Shakyamouni\SiteBundle\Entity\ArticleEvent", cascade={"persist"})
     * @ORM\JoinColumn(name="articleevent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $articleevent;

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
     * Set picture
     *
     * @param string $picture
     * @return Picture
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
     * Set title
     *
     * @param string $title
     * @return Picture
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
     * @return Picture
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
     * Set subCategory
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategory $subCategory
     * @return Picture
     */
    public function setSubCategory(\Shakyamouni\MenuBundle\Entity\SubCategory $subCategory = null)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \Shakyamouni\MenuBundle\Entity\SubCategory 
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Set subCategoryEvent
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategoryEvent $subCategoryEvent
     * @return Picture
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
        return 'uploads/pictureHomepage';
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
     * Set articleevent
     *
     * @param \Shakyamouni\SiteBundle\Entity\ArticleEvent $articleevent
     * @return Picture
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
}