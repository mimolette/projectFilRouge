<?php

namespace ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
  public function findTest() {
    $qb = $this->createQueryBuilder('c');

    // chaque série avec leur note moyenne
//    $qb
//        ->select('s.name')
//        ->addSelect($qb->expr()->avg('e.score').' AS moyenne')
//        ->from('ToolBundle\Entity\Evaluate', 'e')
//        // TODO: ajouter la jointure
//        ->groupBy('e.serie')
//        ->orderBy('moyenne' ,'DESC');
//    $query = $qb->getQuery();

    $qb
        ->select('c.id')
        ->addSelect($qb->expr()->count('ld.id').' AS nbLike')
        ->from('ToolBundle\Entity\LikeDislike', 'ld')
        ->innerJoin('ld.comment', 'c')
        ->where('ld.likeIt = true')
        ->groupBy('c.id')
        ->orderBy('nbLike' ,'DESC');
    $query = $qb->getQuery();

    return $query->getResult();

  }
}
