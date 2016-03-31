<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\LikeDislike;

class LoadLikeDislikeData extends AbstractFixture implements OrderedFixtureInterface
{

  private $nbUsers = 50;

  private function randomizeLike($userId, $com) {
    $like = new LikeDislike();
    $like->setLikeIt(rand(0,1));
    $like->setUser($this->getReference($userId . '-user'));
    $like->setComment($com);

    return $like;
  }

  public function load(ObjectManager $manager)
  {
    $comments = $manager->getRepository('ToolBundle:Comment')->findAll();

    foreach($comments as $comment) {

      $randNbUser = rand(0, 20);
      $users = array();
      for($jj = 0; $jj<$randNbUser; $jj++) {
        do {
          $idUser = rand(1, $this->nbUsers);
        } while(in_array($idUser, $users));
        $users[] = $idUser;
      }
      foreach($users as $idUser) {
        $like = $this->randomizeLike($idUser, $comment);
        $manager->persist($like);
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
    return 9;
  }
}