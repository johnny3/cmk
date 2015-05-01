<?php

namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="info")
 * @ORM\Entity(repositoryClass="Shakyamouni\SiteBundle\Repository\InfoRepository")
 */
class Info
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
     * @var string
     *
     * @ORM\Column(name="center_name", type="string", length=255, nullable=true)
     */
    private $centerName;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="metro", type="string", length=255, nullable=true)
     */
    private $metro;

    /**
     * @var string
     *
     * @ORM\Column(name="building", type="string", length=255, nullable=true)
     */
    private $building;

    /**
     * @var string
     *
     * @ORM\Column(name="interphone", type="string", length=255, nullable=true)
     */
    private $interphone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;
    
    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sentence_footer1", type="string", length=255, nullable=true)
     */
    private $sentenceFooter1;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="sentence_footer2", type="string", length=255, nullable=true)
     */
    private $sentenceFooter2;


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
     * Set centerName
     *
     * @param string $centerName
     * @return Info
     */
    public function setCenterName($centerName)
    {
        $this->centerName = $centerName;

        return $this;
    }

    /**
     * Get centerName
     *
     * @return string 
     */
    public function getCenterName()
    {
        return $this->centerName;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Info
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return Info
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set metro
     *
     * @param string $metro
     * @return Info
     */
    public function setMetro($metro)
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * Get metro
     *
     * @return string 
     */
    public function getMetro()
    {
        return $this->metro;
    }

    /**
     * Set building
     *
     * @param string $building
     * @return Info
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set interphone
     *
     * @param string $interphone
     * @return Info
     */
    public function setInterphone($interphone)
    {
        $this->interphone = $interphone;

        return $this;
    }

    /**
     * Get interphone
     *
     * @return string 
     */
    public function getInterphone()
    {
        return $this->interphone;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Info
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Info
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Info
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Info
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set sentenceFooter1
     *
     * @param string $sentenceFooter1
     * @return Info
     */
    public function setSentenceFooter1($sentenceFooter1)
    {
        $this->sentenceFooter1 = $sentenceFooter1;

        return $this;
    }

    /**
     * Get sentenceFooter1
     *
     * @return string 
     */
    public function getSentenceFooter1()
    {
        return $this->sentenceFooter1;
    }

    /**
     * Set sentenceFooter2
     *
     * @param string $sentenceFooter2
     * @return Info
     */
    public function setSentenceFooter2($sentenceFooter2)
    {
        $this->sentenceFooter2 = $sentenceFooter2;

        return $this;
    }

    /**
     * Get sentenceFooter2
     *
     * @return string 
     */
    public function getSentenceFooter2()
    {
        return $this->sentenceFooter2;
    }
}