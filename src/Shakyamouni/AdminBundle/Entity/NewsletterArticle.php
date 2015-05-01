<?php

namespace Shakyamouni\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NewsletterArticle
 *
 * @ORM\Table(name="newsletter_article")
 * @ORM\Entity(repositoryClass="Shakyamouni\AdminBundle\Repository\NewsletterArticleRepository")
 */
class NewsletterArticle
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $picture;

    /**
     * @Assert\File(maxSize="2M")
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="is_reservation_link", type="boolean", nullable=true)
     */
    private $isReservationLink;

    /**
     * @var integer $position
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $position;
    
     /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\Event", inversedBy="newsletterarticles")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $event;
    
     /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\ArticleEvent", inversedBy="newsletterarticles")
     * @ORM\JoinColumn(name="articleevent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $articleevent;
    
     /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\MenuBundle\Entity\SubCategory", inversedBy="newsletterarticles")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $subCategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\AdminBundle\Entity\Newsletter", inversedBy="newsletterarticles")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $newsletter;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\SiteBundle\Entity\Article", inversedBy="newsletterarticles")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $articleLie;


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
     * Set picture
     *
     * @param string $picture
     * @return NewsletterArticle
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
     * Set body
     *
     * @param string $body
     * @return NewsletterArticle
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
        return 'uploads/newsletter';
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
     * Set newsletter
     *
     * @param \Shakyamouni\AdminBundle\Entity\Newsletter $newsletter
     * @return NewsletterArticle
     */
    public function setNewsletter(\Shakyamouni\AdminBundle\Entity\Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    
        return $this;
    }

    /**
     * Get newsletter
     *
     * @return \Shakyamouni\AdminBundle\Entity\Newsletter 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set isReservationLink
     *
     * @param boolean $isReservationLink
     * @return NewsletterArticle
     */
    public function setIsReservationLink($isReservationLink)
    {
        $this->isReservationLink = $isReservationLink;
    
        return $this;
    }

    /**
     * Get isReservationLink
     *
     * @return boolean 
     */
    public function getIsReservationLink()
    {
        return $this->isReservationLink;
    }

    /**
     * Set subCategory
     *
     * @param \Shakyamouni\MenuBundle\Entity\SubCategory $subCategory
     * @return NewsletterArticle
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
    public function getSubcategory()
    {
        return $this->subCategory;
    }

    /**
     * Set articleLie
     *
     * @param \Shakyamouni\SiteBundle\Entity\Article $articleLie
     * @return NewsletterArticle
     */
    public function setArticleLie(\Shakyamouni\SiteBundle\Entity\Article $articleLie = null)
    {
        $this->articleLie = $articleLie;
    
        return $this;
    }

    /**
     * Get articleLie
     *
     * @return \Shakyamouni\SiteBundle\Entity\Article 
     */
    public function getArticleLie()
    {
        return $this->articleLie;
    }
}