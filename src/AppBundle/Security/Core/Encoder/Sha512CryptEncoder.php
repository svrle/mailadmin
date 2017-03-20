<?php

namespace AppBundle\Security\Core\Encoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class Sha512CryptEncoder extends BasePasswordEncoder
{
    private $ignorePasswordCase;

    /**
     * Constructor.
     *
     * @param bool $ignorePasswordCase Compare password case-insensitive
     */
    public function __construct($ignorePasswordCase = false)
    {
        $this->ignorePasswordCase = $ignorePasswordCase;
    }

    /**
     * {@inheritdoc}
     */
    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }

//        return sha1($this->mergePasswordAndSalt($raw, $salt));
        return crypt($raw, "$6$$salt");
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }

        try {
            $pass2 = $this->encodePassword($raw, $salt);
        } catch (BadCredentialsException $e) {
            return false;
        }

        if (!$this->ignorePasswordCase) {
            return $this->comparePasswords($encoded, $pass2);
        }

        return $this->comparePasswords(strtolower($encoded), strtolower($pass2));
    }

    /**
     * Merges a password and a salt.
     *
     * @param string $password the password to be used
     * @param string $salt     the salt to be used
     *
     * @return string a merged password and salt
     *
     * @throws \InvalidArgumentException
     */
    protected function mergePasswordAndSalt($password, $salt)
    {
        if (empty($salt)) {
            return $password;
        }

        return $salt.$password;
    }
}