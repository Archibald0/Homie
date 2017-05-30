<?php

namespace HomieBundle\Repository;

/**
 * AvailableRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AvailableRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAvailableByDate($date) {
        $date = $date->format('Y-m-d H:i:s');
        return $this->createQueryBuilder('a')
            ->andWhere('a.start_date < :now')
            ->andWhere('a.end_date > :now')

            ->setParameter('now', $date)

            ->orderBy('a.user')

            ->getQuery()
            ->getResult();
    }
}
