<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Picture
 *
 * @ORM\Table(name="picture_slideshow")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\PictureSlideshowRepository")
 */
class PictureSlideshow {

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
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\SlideShow", inversedBy="pictures")
     * @ORM\JoinColumn(name="slideshow_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $slideshow;
    
//    /**
//     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\PictureSize")
//     * @ORM\JoinColumn(name="picture_size_id", referencedColumnName="id", nullable=true)
//     */
//    private $pictureSize;

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
        return 'uploads/pictureSlideshow';
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
     * Set slideshow
     *
     * @param \Shakyamouni\SiteBundle\Entity\SlideShow $slideshow
     * @return PictureSlideshow
     */
    public function setSlideshow(\Shakyamouni\SiteBundle\Entity\SlideShow $slideshow)
    {
        $this->slideshow = $slideshow;
    
        return $this;
    }

    /**
     * Get slideshow
     *
     * @return \Shakyamouni\SiteBundle\Entity\SlideShow 
     */
    public function getSlideshow()
    {
        return $this->slideshow;
    }

//    /**
//     * Set pictureSize
//     *
//     * @param \Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize
//     * @return PictureSlideshow
//     */
//    public function setPictureSize(\Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize = null)
//    {
//        $this->pictureSize = $pictureSize;
//    
//        return $this;
//    }
//
//    /**
//     * Get pictureSize
//     *
//     * @return \Shakyamouni\SiteBundle\Entity\PictureSize 
//     */
//    public function getPictureSize()
//    {
//        return $this->pictureSize;
//    }
}