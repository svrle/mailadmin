<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email")
 */
class Email
{

    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="emails", cascade={"persist"})
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $domain;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $username;

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param mixed $domain
     */
    public function setDomain(Domain $domain)
    {
        $this->domain = $domain;
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

    public function __toString()
    {
        return $this->getUsername();
    }


}