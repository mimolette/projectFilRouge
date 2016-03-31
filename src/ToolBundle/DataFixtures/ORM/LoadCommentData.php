<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\Comment;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{

  private $nbSeries = 45;
  private $nbUsers = 50;
  private $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
  eprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit aeprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit a';

  private function randomizeComment($id, $userId, $serieId) {
    $com = new Comment();
    $years = rand(2013, 2015);
    $month = rand(1, 12);
    $day = rand(1, 28);
    $dateCom = new \DateTime($years . '-' . $month . '-' . $day);
    $dateCom->setTime(rand(0,23), rand(0,59), rand(0,59));
    $com->setPostDate(\DateTime::createFromFormat('Y-m-d:H:m:s', $dateCom->format('Y-m-d:H:m:s')));
    $com->setMessage(substr($this->lorem, 0, rand(50, 500)));
    $com->setValidation(rand(0, 1));
    $com->setUser($this->getReference($userId . '-user'));
    $com->setSerie($this->getReference($serieId . '-serie'));

    $this->setReference($id . '-com', $com);

    return $com;
  }

  public function load(ObjectManager $manager)
  {

    $idcomment = 1;

    for($idUser = 1; $idUser <= $this->nbUsers; $idUser++) {
      $randNbComment = rand(0, 15);
      $series = array();
      for($jj = 0; $jj<$randNbComment; $jj++) {
        do {
          $idSerie = rand(1, $this->nbSeries);
        } while(in_array($idSerie, $series));
        $series[] = $idSerie;
      }
      foreach($series as $idSerie) {
        $comment = $this->randomizeComment($idcomment, $idUser, $idSerie);
        $manager->persist($comment);
        $idcomment++;
      }
    }

    $manager->flush();
  }

  /**
   * Get the order of this fixture
   *
   * @return integer
   */
  public function getOrder()
  {
    return 7;
  }
}