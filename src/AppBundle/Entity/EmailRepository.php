<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmailRepository extends EntityRepository
{
    public function findDomainsAll()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('u')
            ->from('AppBundle:Domain', 'u');

        return $qb->getParameters();
    }

//    public function isSafeForDelete(Domain $domain)
//    {
//        $this->_em->createQueryBuilder()
//            ->select('o')
//            ->from('\Entities\Users', 'u')
//            ->where('u.userid= ?1')
//            ->orderBy('u.?3', '?3')
//            ->setParameter(1, $userid)
//            ->setParameter(2, $orderby)
//            ->setParameter(3, $sort)
//            ->getQuery()
//            ->getResult();
//    }


}