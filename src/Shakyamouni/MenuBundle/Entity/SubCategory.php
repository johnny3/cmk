<?php

namespace Shakyamouni\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SubCategory
 *
 * @ORM\Table(name="subcategory")
 * @ORM\Entity(repositoryClass="Shakyamouni\MenuBundle\Repository\SubCategoryRepository")
 */
class SubCategory {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var boolean
     *
     * @ORM\Column(name="is_visible", type="boolean", nullable=true)
     */
    private $isVisible;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

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
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="metaTitle", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="metaDescription", type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\MenuBundle\Entity\Category", inversedBy="subCategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\SiteBundle\Entity\Article", mappedBy="subCategory") 
     */
    private $articles;
    
    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\AdminBundle\Entity\NewsletterArticle", mappedBy="subCategory")
     */
    private $newsletterarticles;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\PictureSize")
     * @ORM\JoinColumn(name="picture_size_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $pictureSize;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\SlideShow", inversedBy="subCategories")
     * @ORM\JoinColumn(name="slideshow_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $slideshow;

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
        return $this->category->getTitle() . ' / ' . $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return SubCategory
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
     * @return SubCategory
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
     * @return SubCategory
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
     * Set category
     *
     * @param \Shakyamouni\MenuBundle\Entity\Category $category
     * @return SubCategory
     */
    public function setCategory(\Shakyamouni\MenuBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Shakyamouni\MenuBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slideshow
     *
     * @param \Shakyamouni\SiteBundle\Entity\Slideshow $slideshow
     * @return SubCategory
     */
    public function setSlideshow(\Shakyamouni\SiteBundle\Entity\Slideshow $slideshow = null)
    {
        $this->slideshow = $slideshow;

        return $this;
    }

    /**
     * Get slideshow
     *
     * @return \Shakyamouni\SiteBundle\Entity\Slideshow
     */
    public function getSlideshow()
    {
        return $this->slideshow;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SubCategory
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
     * @return SubCategory
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
     * @return SubCategory
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
     * @return SubCategory
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
     * Set pictureSize
     *
     * @param \Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize
     * @return SubCategory
     */
    public function setPictureSize(\Shakyamouni\SiteBundle\Entity\PictureSize $pictureSize = null)
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
     * @return SubCategory
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
     * Add articles
     *
     * @param \Shakyamouni\SiteBundle\Entity\Article $articles
     * @return SubCategory
     */
    public function addArticle(\Shakyamouni\SiteBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;
        $articles->setSubCategory($this);
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Shakyamouni\SiteBundle\Entity\Article $articles
     */
    public function removeArticle(\Shakyamouni\SiteBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
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
     * Add newsletterarticles
     *
     * @param \Shakyamouni\AdminBundle\Entity\NewsletterArticle $newsletterarticles
     * @return SubCategory
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