<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Subscription
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Subscription
     */
    public function setEmail(string $email):Subscription
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
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Subscription
     */
    public function setIpAddress(string $ipAddress):Subscription
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
     * @return Subscription
     */
    public function setCreationDate(\DateTime $creationDate):Subscription
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
}

