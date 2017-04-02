<?php

namespace AppBundle\Model;


class EximInstance
{
    /**
     * ORM\Column(type="string")
     */
    protected $ip;

    /**
     * ORM\Column(type="string")
     */
    protected $hostname;

    /**
     * ORM\Column(type="string")
     */
    protected $name;


    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->name;
    }


}