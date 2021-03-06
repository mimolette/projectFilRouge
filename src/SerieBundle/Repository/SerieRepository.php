<?php

namespace SerieBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * SerieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SerieRepository extends EntityRepository
{
//  #lister tout les commentaire par série avec leur nombre de like
//  SELECT c.id, c.serie_id, COUNT(dl.id) as nb_like
//  FROM comment c
//  INNER JOIN like_dislike dl
//  ON c.id = dl.comment_id
//  WHERE dl.likeIt = TRUE
//  GROUP BY dl.comment_id
//
//  #lister tout les commentaire avec le plus de like par série
//  SELECT s.id as serie_id, r.id as comment_id, MAX(r.nb_like) as nlike
//  FROM serie s
//  INNER JOIN
//  (SELECT c.id, c.serie_id, COUNT(dl.id) as nb_like
//  FROM comment c
//  INNER JOIN like_dislike dl
//  ON c.id = dl.comment_id
//  WHERE dl.likeIt = TRUE
//  GROUP BY dl.comment_id) as r
//  ON r.serie_id = s.id
//  GROUP BY r.serie_id
//
//  #lister les 5 series avec la meilleur note moyenne + le commentaire de chaque série qui
//  # possède le plus de like
//  SELECT s.name, AVG(e.score) as moy, rr.comment_id, rr.nlike
//  FROM evaluate e
//  INNER JOIN serie s
//  ON s.id = e.serie_id
//  INNER JOIN
  //  (SELECT s.id as s_id, r.id as comment_id, MAX(r.nb_like) as nlike
  //  FROM serie s
  //  INNER JOIN
    //  (SELECT c.id, c.serie_id, COUNT(dl.id) as nb_like
    //  FROM comment c
    //  INNER JOIN like_dislike dl
    //  ON c.id = dl.comment_id
    //  WHERE dl.likeIt = TRUE
    //  GROUP BY dl.comment_id) as r
  //  ON r.serie_id = s.id
  //  GROUP BY r.serie_id) as rr
//  ON rr.s_id = s.id
//  GROUP BY serie_id
//  ORDER BY moy DESC
//  LIMIT 5;

  public function getFullDetail($idSerie) {
    $qb = $this->createQueryBuilder('s');

    $qb
        ->addSelect($qb->expr()->avg('e.score').' AS moyenne')
        ->join('s.scores', 'e')
        ->where('s.id = ?1')
        ->setParameter(1, $idSerie);
    $query = $qb->getQuery();


    return $query->getOneOrNullResult();
  }

  /**
   * @param integer $nbResult = the number of results wanted
   * @param integer $nbPage = the page's number, 0 by default
   * @return array
   */
  public function getXSeriesByAvgScore($nbResult = 5, $nbPage = 0) {
    $qb = $this->createQueryBuilder('s');

    $qb
      ->addSelect($qb->expr()->avg('e.score').' AS moyenne')
      ->join('s.scores', 'e')
      ->groupBy('s.id')
      ->where('s.validation = true')
      ->orderBy('moyenne' ,'DESC')
      ->setFirstResult($nbPage * $nbResult)
      ->setMaxResults($nbResult);
    $query = $qb->getQuery();


    return $query->getResult();

  }

  /**
   * @param integer $category = the category Id
   * @param integer $nbResult = the number of results wanted
   * @param integer $nbPage = the page's number, 0 by default
   * @return array
   */
  public function getXSeriesByCategory($category, $nbResult = 30, $nbPage = 0) {
    $qb = $this->createQueryBuilder('s');

    $qb
        ->addSelect($qb->expr()->avg('e.score').' AS moyenne')
        ->join('s.scores', 'e')
        ->innerJoin('s.categories', 'c')
        ->groupBy('s.id')
        ->where('s.validation = true')
        ->andWhere('c.id = ?1')
        ->orderBy('moyenne' ,'DESC')
        ->setFirstResult($nbPage * $nbResult)
        ->setMaxResults($nbResult)
        ->setParameter(1, $category);
    $query = $qb->getQuery();


    return $query->getResult();

  }

  /**
   * @param integer $nbResult = the number of results wanted
   * @param integer $nbPage = the page's number, 0 by default
   * @return array
   */
  public function getXSeriesByNbViewers($nbResult = 30, $nbPage = 0) {
    $qb = $this->createQueryBuilder('s');

    $qb
        ->addSelect($qb->expr()->count('u.id').' AS nbViewers')
        ->leftJoin('s.viewers', 'u')
        ->groupBy('s.id')
        ->where('s.validation = true')
        ->orderBy('nbViewers' ,'DESC')
        ->setFirstResult($nbPage * $nbResult)
        ->setMaxResults($nbResult);
    $query = $qb->getQuery();


    return $query->getResult();

  }

  /**
   * @param $value
   * @return array
   */
  public function getBySearchValue($value) {
    $qb = $this->createQueryBuilder('s');

    $qb
        ->where($qb->expr()->like('s.name', '?1'))
        ->setParameter(1, '%' . $value . '%');
    $query = $qb->getQuery();


    return $query->getResult();
  }
}
