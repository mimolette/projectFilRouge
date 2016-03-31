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
  /**
   * @param $id
   * @return mixed
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getBestCommentBySerieId($id) {
    $qb = $this->createQueryBuilder('c');

    $qb
        // TODO: ajouter le nombre de dislike
        ->addSelect($qb->expr()->count('ld.id').' AS nbLike')
        ->innerJoin('c.likes', 'ld')
        ->where('ld.likeIt = true')
        ->andWhere('c.serie = ?1')
        ->groupBy('c.id')
        ->orderBy('nbLike' ,'DESC')
        ->setMaxResults(1)
        ->setParameter(1, $id);
    $query = $qb->getQuery();

    return $query->getOneOrNullResult();

  }

  /**
   * @param $id
   * @return array
   */
  public function getAllCommentBySerieId($id) {
    $qb = $this->createQueryBuilder('c');

    $qb
        // TODO: ajouter le nombre de dislike
        ->addSelect($qb->expr()->count('ld.id').' AS nbLike')
        ->join('c.likes', 'ld')
        ->where('ld.likeIt = true')
        ->andWhere('c.serie = ?1')
        ->groupBy('c.id')
        ->orderBy('nbLike' ,'DESC')
        ->setParameter(1, $id);
    $query = $qb->getQuery();

    return $query->getResult();
  }

  /**
   * @param $id
   * @return array
   */
  public function getCommentsByUserId($id){
    $qb = $this->createQueryBuilder('c');

    $qb
        ->addSelect('s')
        ->addSelect($qb->expr()->count('ld.id').' AS nbLike')
        ->join('c.serie', 's')
        ->join('c.likes', 'ld')
        ->where('ld.likeIt = true')
        ->andWhere('c.user = ?1')
        ->groupBy('c.id')
        ->orderBy('c.validation', 'DESC')
        ->addOrderBy('c.postDate', 'DESC')
        ->setParameter(1, $id);

    $query = $qb->getquery();

    return $query->getResult();
  }


}
