<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $categories = [
      ['id' => 1,'name' => 'Drame'],
      ['id' => 2,'name' => 'Action'],
      ['id' => 3,'name' => 'Aventure'],
      ['id' => 4,'name' => 'Crime'],
      ['id' => 5,'name' => 'Science-Fiction'],
      ['id' => 6,'name' => 'Fantaisy'],
      ['id' => 7,'name' => 'Policier'],
    ];

    // each Actors
    foreach($categories as $catData) {

      $cat = new Category();
      $cat->setName($catData['name']);

      $manager->persist($cat);
      $this->addReference($catData['id'].'-cat', $cat);
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