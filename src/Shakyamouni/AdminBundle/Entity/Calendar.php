<?php

namespace Shakyamouni\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Picture
 *
 * @ORM\Table(name="calendar")
 * @ORM\Entity(repositoryClass="Shakyamouni\AdminBundle\Repository\CalendarRepository")
 */
class Calendar {
    
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
     * @var string
     *
     * @ORM\Column(name="calendar", type="string", length=255)
     */
    private $calendar;

    /**
     * @Assert\File(maxSize="2M")
     */
    public $file;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;
    
    /**
     * @ORM\OneToMany(targetEntity="Shakyamouni\AdminBundle\Entity\Newsletter", mappedBy="pm", cascade={"persist"})
     */
    private $newsletters;

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
        return $this->calendar . ' ' . '(mis à jour le: ' . $this->updatedAt->format('d/m/Y') . ')';
    }

    public function getWebPath()
    {
        return null === $this->calendar ? null : $this->getUploadDir() . '/' . $this->calendar;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire dans lequel sauvegarder les photos de profil
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/calendrier';
    }

    public function uploadProfilePicture()
    {
        // Nous utilisons le nom de fichier original, donc il est dans la pratique
        // nécessaire de le nettoyer pour éviter les problèmes de sécurité
        // move copie le fichier présent chez le client dans le répertoire indiqué.
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // On sauvegarde le nom de fichier
        $this->calendar = $this->file->getClientOriginalName();

        // La propriété file ne servira plus
        $this->file = null;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Calendar
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
     * @return Calendar
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
     * Set calendar
     *
     * @param string $calendar
     * @return Calendar
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    
        return $this;
    }

    /**
     * Get calendar
     *
     * @return string 
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
    
     /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Calendar
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->newsletters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add newsletters
     *
     * @param \Shakyamouni\AdminBundle\Entity\Newsletter $newsletters
     * @return Calendar
     */
    public function addNewsletter(\Shakyamouni\AdminBundle\Entity\Newsletter $newsletters)
    {
        $this->newsletters[] = $newsletters;
    
        return $this;
    }

    /**
     * Remove newsletters
     *
     * @param \Shakyamouni\AdminBundle\Entity\Newsletter $newsletters
     */
    public function removeNewsletter(\Shakyamouni\AdminBundle\Entity\Newsletter $newsletters)
    {
        $this->newsletters->removeElement($newsletters);
    }

    /**
     * Get newsletters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsletters()
    {
        return $this->newsletters;
    }
}