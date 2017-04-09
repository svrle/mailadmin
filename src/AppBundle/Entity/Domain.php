<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as CustomAssert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DomainRepository")
 * @ORM\Table(name="domain")
 * @UniqueEntity("name")
 */
class Domain
{
    public function __construct()
    {
        $this->emails = new ArrayCollection() ;
        $this->aliases = new ArrayCollection() ;
        $this->encryptions = new ArrayCollection() ;

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
        if( $this->getCountOnlyEmails() < $this->emailNumbers )
        {
            return true;
        } else {
            return false;
        }
    }

    public function isNumberOfAliasValid()
    {
        if( $this->getCountOnlyAliases() < $this->aliasNumbers )
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @ORM\Column(type="string", unique=true, length=255)
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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $defaultQuota;

    protected $countOnlyEmails;

    protected $countOnlyAliases;

    /**
     * @ORM\Column(type="integer")
     */
    protected $aliasNumbers;

    /**
     * @ORM\ManyToMany(targetEntity="Encryption", inversedBy="domains")
     *
     */
    protected $encryptions;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PostfixInstance", inversedBy="domains")
     * @ORM\JoinColumn(name="instance_id", referencedColumnName="id")
     */
    private $instance;

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param mixed $instance
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;
    }

    /**
     * @return mixed
     */
    public function getEncryptions()
    {
        return $this->encryptions;
    }

    /**
     * @param mixed $encryptions
     */
    public function setEncryptions($encryptions)
    {
        $this->encryptions = $encryptions;
    }

    /**
     * @return mixed
     */
    public function getAliasNumbers()
    {
        return $this->aliasNumbers;
    }

    /**
     * @param mixed $aliasNumbers
     */
    public function setAliasNumbers($aliasNumbers)
    {
        $this->aliasNumbers = $aliasNumbers;
    }

    /**
     * @return mixed
     */
    public function getCountOnlyAliases()
    {
        $this->countOnlyAliases = count($this->getOnlyAliases());
        return $this->countOnlyAliases;
    }

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


    public function getOnlyEmails()
    {
        $emails = array();
        foreach ($this->getEmails() as $email)
        {
            if($email->getPassword() != null )
            {
                $emails[] = $email;
            }
        }
        return $emails;
    }

    public function getOnlyAliases()
    {
        $aliases = array();
        foreach ($this->getEmails() as $alias)
        {
            if($alias->getPassword() == null )
            {
                $aliases[] = $alias;
            }
        }
        return $aliases;
    }


    /**
     * @return mixed
     */
    public function getCountOnlyEmails()
    {
        $this->countOnlyEmails = count($this->getOnlyEmails());
        return $this->countOnlyEmails;
    }

    /**
     * @param mixed $emails
     */
    public function setEmails(Email $emails)
    {
        $this->emails = $emails;
    }




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