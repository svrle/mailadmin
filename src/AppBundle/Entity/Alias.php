<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="alias")
 */
class Alias
{

    public function __construct()
    {
        $this->emails = new ArrayCollection() ;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Email", inversedBy="aliases")
     * @ORM\JoinTable(name="tbl_alias_amail")
     */
    protected $emails;

    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="aliases", cascade={"persist"})
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $domain;

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
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param mixed $emails
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
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
//        return $this->getUsername();
//    }


}