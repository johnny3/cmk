<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="slideshow")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\SlideShowRepository")
 */
class SlideShow {

    public function __construct()
    {
        $this->subCategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategory", mappedBy="slideshow")
     */
    private $subCategories;

    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\SiteBundle\Entity\PictureSlideshow", mappedBy="slideshow")
     */
    private $pictures;

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
     * @return SlideShow
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
     * @return SlideShow
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
     * @return SlideShow
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
     * @return SlideShow
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
     * Add subCategories
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategory $subCategories
     * @return SlideShow
     */
    public function addSubCategorie(\Shakyamouni\MenuBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;
        $subCategories->setSlideshow($this);
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

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * Add pictures
     *
     * @param \Shakyamouni\SiteBundle\Entity\PictureSlideshow $pictures
     * @return SlideShow
     */
    public function addPicture(\Shakyamouni\SiteBundle\Entity\PictureSlideshow $pictures)
    {
        $this->pictures[] = $pictures;
        $pictures->setSlideshow($this);
        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \Shakyamouni\SiteBundle\Entity\PictureSlideshow $pictures
     */
    public function removePicture(\Shakyamouni\SiteBundle\Entity\PictureSlideshow $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPictures()
    {
        return $this->pictures;
    }
}