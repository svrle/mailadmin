<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class DomainRepository extends EntityRepository
{
    public function findDomainsAll()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('u')
            ->from('AppBundle:Domain', 'u');

        return $qb->getParameters();
    }


}