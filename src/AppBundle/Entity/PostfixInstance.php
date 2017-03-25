<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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

    public function __toString()
    {
        return $this->name;
    }

    public function createFolderStructure()
    {
//        $this->
        $processBuilder = new ProcessBuilder();
        $processBuilder->setPrefix('/usr/bin/cp');
        $processBuilder->setArguments(array('-rp', '/etc/postfix/', '~/', $this->getName()));
//        $processBuilder->getProcess();

        $process = new Process('/usr/bin/cp -rp /etc/postfix/ ~/' . $this->getName());
        $process->run();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $ip;

    /**
     * @ORM\Column(type="string")
     */
    protected $hostname;

    /**
     * @ORM\Column(type="string")
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

}