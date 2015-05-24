<?php

namespace Shakyamouni\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * SubscriptionEvent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Shakyamouni\UserBundle\Repository\SubscriptionEventRepository")
 */
class SubscriptionEvent
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
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="cellphone", type="string", length=255, nullable=true)
     */
    private $cellphone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="additionnalInformation", type="text", nullable=true)
     */
    private $additionnalInformation;

    /**
     * @var string
     *
     * @ORM\Column(name="knowledge", type="string", length=255, nullable=true)
     */
    private $knowledge;

    /**
     * @ORM\ManyToOne(targetEntity="Shakyamouni\AdminBundle\Entity\Subscription", inversedBy="subscriptionEvent")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=false)
     */
    private $subscription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_payed", type="boolean", nullable=false)
     */
    private $hasPayed;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_optin", type="boolean", nullable=true)
     */
    private $isOptin;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="string", length=255, nullable=true)
     */
    private $other;

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
     * Set firstname
     *
     * @param string $firstname
     * @return SubscriptionEvent
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return SubscriptionEvent
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set cellphone
     *
     * @param string $cellphone
     * @return SubscriptionEvent
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Get cellphone
     *
     * @return string 
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return SubscriptionEvent
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
     * Set price
     *
     * @param string $price
     * @return SubscriptionEvent
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set additionnalInformation
     *
     * @param string $additionnalInformation
     * @return SubscriptionEvent
     */
    public function setAdditionnalInformation($additionnalInformation)
    {
        $this->additionnalInformation = $additionnalInformation;

        return $this;
    }

    /**
     * Get additionnalInformation
     *
     * @return string 
     */
    public function getAdditionnalInformation()
    {
        return $this->additionnalInformation;
    }

    /**
     * Set knowledge
     *
     * @param string $knowledge
     * @return SubscriptionEvent
     */
    public function setKnowledge($knowledge)
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    /**
     * Get knowledge
     *
     * @return string 
     */
    public function getKnowledge()
    {
        return $this->knowledge;
    }

    /**
     * Set subscription
     *
     * @param \Shakyamouni\AdminBundle\Entity\Subscription $subscription
     * @return SubscriptionEvent
     */
    public function setSubscription(\Shakyamouni\AdminBundle\Entity\Subscription $subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * Get subscription
     *
     * @return \Shakyamouni\AdminBundle\Entity\Subscription 
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set hasPayed
     *
     * @param boolean $hasPayed
     * @return SubscriptionEvent
     */
    public function setHasPayed($hasPayed)
    {
        $this->hasPayed = $hasPayed;

        return $this;
    }

    /**
     * Get hasPayed
     *
     * @return boolean 
     */
    public function getHasPayed()
    {
        return $this->hasPayed;
    }

    /**
     * Set isOptin
     *
     * @param boolean $isOptin
     * @return SubscriptionEvent
     */
    public function setIsOptin($isOptin)
    {
        $this->isOptin = $isOptin;

        return $this;
    }

    /**
     * Get isOptin
     *
     * @return boolean 
     */
    public function getIsOptin()
    {
        return $this->isOptin;
    }

    /**
     * Set other
     *
     * @param string $other
     * @return SubscriptionEvent
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string 
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getKnowledge() == 'autre' && $this->getOther() == null) {
            $context->addViolationAt(
                'other', "Vous devez remplir ce champ si vous avez coché 'autre'", array(), null
            );
        }
    }
}