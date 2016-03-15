<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Actor;

class LoadActorData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $actors = [
      ['id' => 1,'firstname' => 'Brad', 'lastname' => 'Garrett'],
      ['id' => 2,'firstname' => 'Eddie', 'lastname' => 'Thomas'],
      ['id' => 3,'firstname' => 'Joely', 'lastname' => 'Fisher'],
      ['id' => 4,'firstname' => 'Kat', 'lastname' => 'Foster'],
      ['id' => 5,'firstname' => 'Michael', 'lastname' => 'Socha'],
      ['id' => 6,'firstname' => 'Michaela', 'lastname' => 'Coel'],
      ['id' => 7,'firstname' => 'Michael', 'lastname' => 'Weston'],
      ['id' => 8,'firstname' => 'Stephen', 'lastname' => 'Mangan'],
      ['id' => 9,'firstname' => 'Titus', 'lastname' => 'Welliver'],
      ['id' => 10,'firstname' => 'Amy', 'lastname' => 'Price-Francis'],
      ['id' => 11,'firstname' => 'Annie', 'lastname' => 'Wersching'],
      ['id' => 12,'firstname' => 'Bradley', 'lastname' => 'James'],
      ['id' => 13,'firstname' => 'Megalyn', 'lastname' => 'Echikunwoke'],
      ['id' => 14,'firstname' => 'Omid', 'lastname' => 'Abtahi'],
      ['id' => 15,'firstname' => 'Barbara', 'lastname' => 'Hershey'],
      ['id' => 16,'firstname' => 'Stephen', 'lastname' => 'Amell'],
      ['id' => 17,'firstname' => 'Willa', 'lastname' => 'Holland'],
      ['id' => 18,'firstname' => 'David', 'lastname' => 'Ramsey'],
      ['id' => 19,'firstname' => 'Brad', 'lastname' => 'Pitt'],
      ['id' => 20,'firstname' => 'Emily', 'lastname' => 'Bett Rickards'],
    ];

    // each Actors
    foreach($actors as $actorData) {

      $actor = new Actor();
      $actor->setFirstname($actorData['firstname']);
      $actor->setLastname($actorData['lastname']);

      $manager->persist($actor);
      $this->addReference($actorData['id'].'-actor', $actor);
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
    return 2;
  }
}