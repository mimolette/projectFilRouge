<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Actor;

class LoadActorData extends AbstractFixture implements OrderedFixtureInterface
{
  private $nbActors = 150;

  private function randomizeActor($id) {
    $actor = new Actor();
    $actor->setFirstname('actor' . $id);
    $actor->setLastname('actor' . $id);

    $this->addReference($id.'-actor', $actor);

    return $actor;
  }

  public function load(ObjectManager $manager)
  {

    for($ii = 1; $ii<=$this->nbActors; $ii++) {
      $actor = $this->randomizeActor($ii);
      $manager->persist($actor);
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
    return 1;
  }
}