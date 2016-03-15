<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Serie;

class LoadSerieData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    $series = [
        [
            'name' => 'Louis la Brocante',
            'poster' => 'wf_img.jpg',
            'valid' => true,
            'actors' => [1,5,8,9],
            'categories' => [1,2,3]
        ],
        [
          'name' => 'Fan fan la tulipe',
          'poster' => 'wf_img.jpg',
          'valid' => true,
          'actors' => [11,12,15,18,19],
          'categories' => [4]
        ],
        [
          'name' => 'Breaking Bad',
          'poster' => 'wf_img.jpg',
          'valid' => true,
          'actors' => [14,15,18,7,6],
          'categories' => [4,6]
        ],
        [
          'name' => 'Green',
          'poster' => 'wf_img.jpg',
          'valid' => false,
          'actors' => [2,5,6,8,10],
          'categories' => [7]
        ],
        [
          'name' => 'Grand Papa',
          'poster' => 'wf_img.jpg',
          'valid' => true,
          'actors' => [10,11,12,13,14,15],
          'categories' => [7]
        ],
    ];
    // each Series
    foreach($series as $serieData) {
      $serie = new Serie();
      $serie->setName($serieData['name']);
      $serie->setSynopsis($lorem);
      $serie->setPoster($serieData['poster']);
      $serie->setValidation($serieData['valid']);
      // each actors
      foreach($serieData['actors'] as $actor) {
        $serie->addActor($this->getReference($actor.'-actor'));
      }

      // each category
      foreach($serieData['categories'] as $cat) {
        $serie->addCategory($this->getReference($cat.'-cat'));
      }

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
    return 4;
  }
}