<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EmailRepository")
 * ORM\Entity()
 * @ORM\Table(name="email")
 * AttributeOverrides({
 *     AttributeOverride(name="email",
 *         column=ORM\Column(
 *             name="email",
 *             type="string",
 *             length=255,
 *             unique=false,
 *             nullable=true
 *         )
 *     ),
 *     ORM\AttributeOverride(name="emailCanonical",
 *          column=ORM\Column(
 *              name = "email_canonical",
 *              nullable = true
 *          )
 *      ),
 *     ORM\AttributeOverride(name="password",
 *          column=ORM\Column(
 *              name = "password",
 *              nullable = true
 *          )
 *      ),
 *     ORM\AttributeOverride(name="username",
 *          column=ORM\Column(
 *              name = "username",
 *              nullable = true,
 *              unique=false
 *          )
 *      ),
 *     ORM\AttributeOverride(name="usernameCanonical",
 *          column=ORM\Column(
 *              name = "username_canonical",
 *              nullable = true,
 *              unique=false
 *          )
 *      )
 * })
 * @UniqueEntity(fields={"username", "domain"})
 */
class Email implements UserInterface, \Serializable //, EncoderAwareInterface
{
    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }

    public function __toString()
    {
//        return $this->getUsername();
        return $this->getFullEmail();

    }

    public function getFullEmail()
    {
        return $this->getUsername() . '@' . $this->getDomain();
    }

//    public function getEncoderName()
//    {
//        return 'passsha512';
//    }


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
     * @ORM\Column(type="string", length=255)
     * Assert\NotBlank(groups={"alias"})
     */
    protected $username;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $surname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $quota;

    /**
     * @ORM\ManyToMany(targetEntity="Email", inversedBy="aliases")
     * @ORM\JoinTable(name="emails_aliases")
     */
    protected $emails;

    /**
     * @ORM\ManyToMany(targetEntity="Email", mappedBy="emails")
     */
    protected $aliases;

    /**
     * ORM\Column(type="string", length=60, unique=true)
     */
//    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $salt;

    /**
     * @return mixed
     */
//    public function getEmail()
//    {
//        return $this->email;
//    }

    /**
     * @param mixed $email
     */
//    public function setEmail($email)
//    {
//        $this->email = $email;
//    }

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
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
     * @return mixed
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param mixed $aliases
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }




    /**
     * @return mixed
     */
    public function getQuota()
    {
        if($this->quota == null)
        {
            $this->quota = $this->getDomain()->getDefaultQuota();
        }
        return $this->quota;
    }

    /**
     * @param mixed $quota
     */
    public function setQuota($quota)
    {
        $this->quota = $quota;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

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


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
             $this->salt,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
             $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return array('ROLE_CLIENT');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
//    public function getPassword()
//    {
//        // TODO: Implement getPassword() method.
//    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
//    public function getUsername()
//    {
//        // TODO: Implement getUsername() method.
//    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}