<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="property")
 */
class Property
{
    public function __construct()
    {
        $this->postfixInstances = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="text")
     */
    protected $value;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isNew;

    /**
     * @return mixed
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * @param mixed $isNew
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
    }

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PostfixInstance", mappedBy="properties")
     */
    private $postfixInstances;

    /**
     * @return mixed
     */
    public function getPostfixInstances()
    {
        return $this->postfixInstances;
    }

    /**
     * @param PostfixInstance $postfixInstance
     * @internal param mixed $postfixInstances
     */
    public function addPostfixInstance(PostfixInstance $postfixInstance)
    {
        if(!$this->postfixInstances->contains($postfixInstance)) {
            $postfixInstance->addProperty($this);
            $this->postfixInstances->add($postfixInstance);
        }
    }

    public function removePostfixInstance(PostfixInstance $postfixInstance)
    {
        if($this->postfixInstances->contains($postfixInstance)) {
            $this->postfixInstances->removeElement($postfixInstance);
            $postfixInstance->removeProperty($this);
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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
    public function getId()
    {
        return $this->id;
    }



}