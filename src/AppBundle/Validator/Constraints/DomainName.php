<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class DomainName extends Constraint
{
    const INVALID_URL_ERROR = '57c2f299-1154-4870-89bb-ef3b1f5ad229';

    public $message = 'The string "%string%" contains an illegal character: it can only contain letters or numbers.';

    public $dnsMessage = 'The host could not be resolved.';
    public $protocols = array('http', 'https');
    public $checkDNS = true;

    protected static $errorNames = array(
        self::INVALID_URL_ERROR => 'INVALID_URL_ERROR',
    );
}