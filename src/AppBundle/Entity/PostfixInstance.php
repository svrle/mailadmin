<?php

namespace AppBundle\Entity;

use AppBundle\Controller\PostfixInstanceController;
use AppBundle\Process\PostfixProcess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="postfix")
 * @UniqueEntity("ip")
 * @UniqueEntity("hostname")
 * @UniqueEntity("name")
 */
class PostfixInstance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $ip;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $hostname;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Property", inversedBy="postfixInstances", cascade={"persist"})
     * @ORM\JoinTable(name="postfixInstance_property")
     */
    private $properties;


    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="postfixInstance", cascade={"persist"}, orphanRemoval=true)
     */
    protected $services;

    /**
     * @ORM\OneToMany(targetEntity="Domain", mappedBy="postfixInstance", cascade={"persist"}, orphanRemoval=true)
     */
    protected $domains;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $master;

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
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isSingleInstance;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->services = new ArrayCollection() ;
        $this->domains = new ArrayCollection() ;
    }

    public function __toString()
    {
        return $this->name;
    }


    //second
    /**
     * Need to set configuration of main.cf before creating spool structure and activate instance
     *
     * # DNS name of second IP address
    inet_interfaces = squeezel2.squeezel.com
    myhostname = squeezel2.squeezel.com
    queue_directory = /var/spool/postfix2
    # Inform 2nd instance of other version
    alternative_config_directories = /etc/postfix
    smtp_bind_address = 192.168.1.81
    # Separate Logging
    syslog_name=postfix2
    # Make sure settings go to /etc/postfix2
    transport_maps = hash:/etc/postfix2/transport

     */

    // third
//    public function createSpoolStructure()
//    {
//        $processBuilder = (new ProcessBuilder())
//            ->setPrefix('/usr/bin/mkdir')
//            ->add('-p')
//            ->add('/var/spool/postfix-' . $this->getName());
//
//        $process = $processBuilder->getProcess();
//        $process->run();
//    }

    /**
     * @return mixed
     */
    public function getIsSingleInstance()
    {
        return $this->isSingleInstance;
    }

    /**
     * @param mixed $isSingleInstance
     */
    public function setIsSingleInstance($isSingleInstance)
    {
        $this->isSingleInstance = $isSingleInstance;
    }

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

    public function addProperty(Property $property)
    {
        if(!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->addPostfixInstance($this);
        }
    }

    public function removeProperty(Property $property)
    {
        if($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            $property->removePostfixInstance($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * @param mixed $master
     */
    public function setMaster($master)
    {
        $this->master = $master;
    }



}