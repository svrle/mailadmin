<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as CustomAssert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DomainRepository")
 * @ORM\Table(name="domain")
 */
class Domain
{
    public function __construct()
    {
        $this->emails = new ArrayCollection() ;
    }

    public function getEmailCount()
    {
        return count($this->getEmails());
    }

    /**
     * @return bool
     * @Assert\IsTrue(message="There is more emails")
     */
    public function isNumberOfEmailsValid()
    {
        if( $this->getEmailCount() <= $this->emailNumbers )
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @ORM\Column(type="text")
     * @CustomAssert\DomainName(checkDNS=true)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="domain", cascade={"persist"}, orphanRemoval=true)
     */
    protected $emails;

    /**
     * @ORM\Column(type="integer")
     */
    protected $emailNumbers;

    /**
     * @ORM\Column(type="integer")
     */
    protected $defaultQuota;


    /**
     * @return mixed
     */
    public function getDefaultQuota()
    {
        return $this->defaultQuota;
    }

    /**
     * @param mixed $defaultQuota
     */
    public function setDefaultQuota($defaultQuota)
    {
        $this->defaultQuota = $defaultQuota;
    }

    /**
     * @return mixed
     */
    public function getEmailNumbers()
    {
        return $this->emailNumbers;
    }

    /**
     * @param mixed $emailNumbers
     */
    public function setEmailNumbers($emailNumbers)
    {
        $this->emailNumbers = $emailNumbers;
    }

    /**
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param mixed $emails
     */
    public function setEmails(Email $emails)
    {
        $this->emails = $emails;
    }


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    public function __toString()
    {
        return $this->getName();
    }

}