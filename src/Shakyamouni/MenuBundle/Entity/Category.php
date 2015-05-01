<?php

namespace Shakyamouni\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Shakyamouni\MenuBundle\Repository\CategoryRepository")
 */
class Category {

    public function __construct()
    {
        $this->subCategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->eventCat = false;
        $this->calendarCat = false;
        $this->contactCat = false;
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
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @var integer
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
     * @ORM\Column(name="chapo", type="text", nullable=true)
     */
    private $chapo;

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
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategory", mappedBy="category")
     */
    private $subCategories;

    /**
     * @var boolean
     *
     * @ORM\Column(name="event_cat", type="boolean", nullable=true)
     */
    private $eventCat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="contact_cat", type="boolean", nullable=true)
     */
    private $contactCat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="calendar_cat", type="boolean", nullable=true)
     */
    private $calendarCat;

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
     * @param \DateTime $createdAt
     * @return Category
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
     * @return Category
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
     * Set slug
     *
     * @param string $slug
     * @return Category
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
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
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
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Set picture
     *
     * @param string $picture
     * @return Category
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
     * Set pictureSize
     *
     * @param \Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize
     * @return sCategory
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
    
    /**
     * Set chapo
     *
     * @param string $chapo
     * @return Article
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
     * Set body
     *
     * @param string $body
     * @return Category
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
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Category
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Category
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set eventCat
     *
     * @param boolean $eventCat
     * @return Category
     */
    public function setEventCat($eventCat)
    {
        $this->eventCat = $eventCat;

        return $this;
    }

    /**
     * Get eventCat
     *
     * @return boolean 
     */
    public function getEventCat()
    {
        return $this->eventCat;
    }

    /**
     * Set contactCat
     *
     * @param boolean $contactCat
     * @return Category
     */
    public function setContactCat($contactCat)
    {
        $this->contactCat = $contactCat;

        return $this;
    }

    /**
     * Get contactCat
     *
     * @return boolean 
     */
    public function getContactCat()
    {
        return $this->contactCat;
    }

    /**
     * Set calendarCat
     *
     * @param boolean $calendarCat
     * @return Category
     */
    public function setCalendarCat($calendarCat)
    {
        $this->calendarCat = $calendarCat;

        return $this;
    }

    /**
     * Get calendarCat
     *
     * @return boolean 
     */
    public function getCalendarCat()
    {
        return $this->calendarCat;
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubCategories()
    {
        return $this->subCategories;
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
     * @return Category
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
     * Add subCategories
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategory $subCategories
     * @return Category
     */
    public function addSubCategorie(\Shakyamouni\MenuBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;
        $subCategories->setCategory($this);
        return $this;
    }

    /**
     * Remove subCategories
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategory $subCategories
     */
    public function removeSubCategorie(\Shakyamouni\MenuBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories->removeElement($subCategories);
    }
}