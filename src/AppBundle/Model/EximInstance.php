<?php

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;


class EximInstance
{
    /**
     * ORM\Column(type="string")
     */
    public $value;

    /**
     * @Assert\Type("integer")
     */
    public $type;

    /**
     * ORM\Column(type="string")
     */
    public $name;


    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->name;
    }


}