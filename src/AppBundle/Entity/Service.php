<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Service
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="service")
 */
class Service
{

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->properties = new ArrayCollection() ;
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
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $private;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $unpriv;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $chroot;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $wakeup;

    /**
     * @ORM\Column(type="integer")
     */
    protected $maxproc;

    /**
     * @ORM\Column(type="string")
     */
    protected $command;

    /**
     * @ORM\ManyToOne(targetEntity="PostfixInstance", inversedBy="services", cascade={"persist"})
     * @ORM\JoinColumn(name="postfixInstance_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $postfixInstance;

    /**
     * @ORM\OneToMany(targetEntity="Property", mappedBy="service", cascade={"persist"}, orphanRemoval=true)
     */
    protected $properties;

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
//    public function setProperties($properties)
//    {
//        $this->properties = $properties;
//    }
    public function addProperty(Property $property)
    {
        if(!$this->properties->contains($property)) {
            $property->setService($this);
            $this->properties->add($property);
        }
    }

    public function removeProperty(Property $property)
    {
        if($this->properties->contains($property)) {
            $this->properties->removeElement($property);
//            $property->removeService($this);
        }
    }

    /**
     * @return mixed
     */
    public function getPostfixInstance()
    {
        return $this->postfixInstance;
    }

    /**
     * @param mixed $postfixInstance
     */
    public function setPostfixInstance($postfixInstance)
    {
        $this->postfixInstance = $postfixInstance;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getMaxproc()
    {
        return $this->maxproc;
    }

    /**
     * @param mixed $maxproc
     */
    public function setMaxproc($maxproc)
    {
        $this->maxproc = $maxproc;
    }

    /**
     * @return mixed
     */
    public function getWakeup()
    {
        return $this->wakeup;
    }

    /**
     * @param mixed $wakeup
     */
    public function setWakeup($wakeup)
    {
        $this->wakeup = $wakeup;
    }

    /**
     * @return mixed
     */
    public function getChroot()
    {
        return $this->chroot;
    }

    /**
     * @param mixed $chroot
     */
    public function setChroot($chroot)
    {
        $this->chroot = $chroot;
    }

    /**
     * @return mixed
     */
    public function getUnpriv()
    {
        return $this->unpriv;
    }

    /**
     * @param mixed $unpriv
     */
    public function setUnpriv($unpriv)
    {
        $this->unpriv = $unpriv;
    }

    /**
     * @return mixed
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param mixed $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}