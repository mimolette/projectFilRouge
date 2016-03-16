<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\LikeDislike;

class LoadLikeDislikeData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $min = 3;
    $max = 20;

    $users = [
        'superMan-user',
        'darkLegolas666-user',
        'guiGuiLeBof-user'
    ];

    $nbCom = 56;

    // each com
    for($ii = 0; $ii < $nbCom; $ii++) {

      $nbLikeDislike = rand($min, $max);
      for ($jj = 0; $jj < $nbLikeDislike; $jj++) {
        $like = new LikeDislike();
        $like->setLikeIt(rand(0,1));
        $like->setUser($this->getReference($users[rand(0,2)]));
        $like->setComment($this->getReference($ii . '-com'));

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