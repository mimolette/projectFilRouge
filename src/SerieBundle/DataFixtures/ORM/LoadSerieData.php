<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Serie;

class LoadSerieData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $series = [
        [
            'name' => 'Louis la Brocante',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'poster' => 'wf_img.jpg',
            'valid' => true,
        ],
        [
          'name' => 'Fan fan la tulipe',
          'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labo reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          'poster' => 'wf_img.jpg',
          'valid' => true,
        ],
        [
          'name' => 'Breaking Bad',
          'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labo reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          'poster' => 'wf_img.jpg',
          'valid' => true,
        ],
        [
          'name' => 'Green',
          'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labo reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          'poster' => 'wf_img.jpg',
          'valid' => false,
        ],
        [
            'name' => 'Grand Papa',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labo reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'poster' => 'wf_img.jpg',
            'valid' => true,
        ],
    ];
    // each Series
    foreach($series as $serieData) {
      $serie = new Serie();
      $serie->setName($serieData['name']);
      $serie->setSynopsis($serieData['synopsis']);
      $serie->setPoster($serieData['poster']);
      $serie->setValidation($serieData['valid']);

      $manager->persist($serie);
      $this->addReference($serieData['name'].'-serie', $serie);
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