<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="postfix")
 */
class PostfixInstance
{
    public function __construct()
    {
        $this->domains = new ArrayCollection() ;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $ip;

    /**
     * @ORM\Column(type="text")
     */
    protected $hostname;

    /**
     * @ORM\Column(type="text")
     */
    protected $username;

    /**
     * @ORM\Column(type="text")
     */
    protected $sshkey;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Domain", mappedBy="postfixInstance", cascade={"persist"}, orphanRemoval=true)
     */
    protected $domains;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Property", inversedBy="postfixInstances")
     * @ORM\JoinTable(name="postfixInstance_property")
     */
    private $properties;

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param mixed $domains
     */
    public function setDomains($domains)
    {
        $this->domains = $domains;
    }

    /**
     * @return mixed
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

    /**
     * @return mixed
     */
    public function getSshkey()
    {
        return $this->sshkey;
    }

    /**
     * @param mixed $sshkey
     */
    public function setSshkey($sshkey)
    {
        $this->sshkey = $sshkey;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



//    public function __toString()
//    {
//        return $this->getUsername();
//    }


}