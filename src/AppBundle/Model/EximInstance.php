<?php

namespace AppBundle\Model;


class EximInstance
{
    /**
     * ORM\Column(type="string")
     */
    public $value;

    /**
     * ORM\Column(type="string")
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