<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subscription
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=64, nullable=false)
     */
    private $ipAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date", nullable=false)
     */
    private $creationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="sent", type="boolean", nullable=false)
     */
    private $sent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_date", type="date", nullable=true)
     */
    private $sentDate;

    /**
     * Contact constructor.
     */
    public function __construct()
    {
        $this->sent = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contact
     */
    public function setName(string $name):Contact
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail(string $email):Contact
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject(string $subject):Contact
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject():string
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage(string $message):Contact
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage():string
    {
        return $this->message;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Contact
     */
    public function setIpAddress(string $ipAddress):Contact
    {
        if ($this->getIpAddress() === null) {
            $this->ipAddress = $ipAddress;
        }

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string|null
     */
    public function getIpAddress():?string
    {
        return $this->ipAddress;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Contact
     */
    public function setCreationDate(\DateTime $creationDate):Contact
    {
        if ($this->getCreationDate() === null) {
            $this->creationDate = $creationDate;
        }
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime|null
     */
    public function getCreationDate():?\DateTime
    {
        return $this->creationDate;
    }

    /**
     * Set sent
     *
     * @param bool $sent
     *
     * @return Contact
     */
    public function setSent(bool $sent):Contact
    {
        $this->sent = $sent;
        if ($this->isSent()) {
            $this->setSentDate(new \DateTime());
        }

        return $this;
    }

    /**
     * Get sent
     *
     * @return bool
     */
    public function isSent():bool
    {
        return $this->sent;
    }

    /**
     * Set sentDate
     *
     * @param \DateTime|null $sentDate
     *
     * @return Contact
     */
    public function setSentDate(?\DateTime $sentDate):Contact
    {
        $this->sentDate = $sentDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime|null
     */
    public function getSentDate():?\DateTime
    {
        return $this->sentDate;
    }
}

