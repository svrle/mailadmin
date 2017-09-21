<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as CustomAssert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ServerRepository")
 * @ORM\Table(name="server")
 * @UniqueEntity("ip")
 */
class Server
{
    public function __construct()
    {

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


//    public function __toString()
//    {
//        return $this->getName();
//    }

}