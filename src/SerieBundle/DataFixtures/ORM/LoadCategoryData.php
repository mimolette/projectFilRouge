<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

  private $nbcategories = 12;

  private function randomizeCategory($id) {
    $cat = new Category();
    $cat->setName('category n' . $id);

    $this->addReference($id.'-cat', $cat);

    return $cat;
  }

  public function load(ObjectManager $manager)
  {

    for($ii = 1; $ii<=$this->nbcategories; $ii++) {
      $cat = $this->randomizeCategory($ii);
      $manager->persist($cat);
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