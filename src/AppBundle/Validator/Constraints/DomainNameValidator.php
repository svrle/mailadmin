<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DomainNameValidator extends ConstraintValidator
{
    const PATTERN = '~^
        ((%s)://)?                                 # protocol
        (
        ([a-z0-9-]+\.)+[a-z]{2,6}             # a domain name
        |                                   #  or
        \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
        )
        (:[0-9]+)?                              # a port (optional)
        (/?|/\S+)                               # a /, nothing or a / with something
        $~ix';

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DomainName) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Url');
        }
        if (null === $value) {
            return;
        }
        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }
        $value = (string) $value;
        if ('' === $value) {
            return;
        }
        $pattern = sprintf(static::PATTERN, implode('|', $constraint->protocols));
        if (!preg_match($pattern, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(DomainName::INVALID_URL_ERROR)
                ->addViolation();
            return;
        }
        if ($constraint->checkDNS) {
//            $host = parse_url($value, PHP_URL_HOST); //original line
            $host = $value; //custom svrle change

            if (!checkdnsrr($host, 'ANY')) {
                $this->context->buildViolation($constraint->dnsMessage)
                    ->setParameter('{{ value }}', $this->formatValue($host))
                    ->setCode(DomainName::INVALID_URL_ERROR)
                    ->addViolation();
            }
        }
    }
}