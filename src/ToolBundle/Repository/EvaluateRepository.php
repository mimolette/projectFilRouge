<?php

namespace ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EvaluateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvaluateRepository extends EntityRepository
{
  public function checkValid($userId, $serieId)
  {
    $qb = $this->createQueryBuilder('e');
    $qb
        ->where('e.user = :user')
        ->andWhere('e.serie = :serie')
        ->setParameter('user', $userId)
        ->setParameter('serie', $serieId);
    $query = $qb->getQuery();

    return $query->getOneOrNullResult();
  }

  public function findAvgForOneSerie($serieId) {
    $qb = $this->createQueryBuilder('e');
    $qb
        ->select($qb->expr()->avg('e.score').' AS moyenne')
        ->where('e.serie = :serie')
        ->setParameter('serie', $serieId);
    $query = $qb->getQuery();

    return $query->getOneOrNullResult();
  }
}
