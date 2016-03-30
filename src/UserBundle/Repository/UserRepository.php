<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ActorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
  /**
   * @param $value
   * @return array
   */
  public function getBySearchValue($value) {
    $qb = $this->createQueryBuilder('u');

    $qb
        ->where($qb->expr()->like('u.username', '?1'))
        ->setParameter(1, '%' . $value . '%');
    $query = $qb->getQuery();


    return $query->getResult();
  }
}