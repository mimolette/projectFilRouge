<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Season;

class LoadSeasonData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $seasons = [
      [
        'name' => 'Long fleuve pas tranquil',
        'num' => 1,
        'serie' => 'Louis la Brocante',
      ],
      [
        'name' => 'Rivière pas pourpre',
        'num' => 2,
        'serie' => 'Louis la Brocante',
      ],
      [
        'name' => 'Chien et chat',
        'num' => 1,
        'serie' => 'Fan fan la tulipe',
      ],
      [
        'name' => 'Arco',
        'num' => 1,
        'serie' => 'Breaking Bad',
      ],
      [
        'name' => 'Mange ta soupe',
        'num' => 2,
        'serie' => 'Breaking Bad',
      ],
      [
        'name' => 'Range ta chambre',
        'num' => 3,
        'serie' => 'Breaking Bad',
      ],
      [
        'name' => 'Trogodyte',
        'num' => 4,
        'serie' => 'Breaking Bad',
      ],
      [
        'name' => 'Momo et le chien',
        'num' => 1,
        'serie' => 'Green',
      ],
      [
        'name' => 'Greg et jean',
        'num' => 2,
        'serie' => 'Green',
      ],
    ];
    // each Seasons
    foreach($seasons as $seasonData) {
      $season = new Season();
      $season->setName($seasonData['name']);
      $season->setNum($seasonData['num']);
      $season->setSerie($this->getReference($seasonData['serie'].'-serie'));

      $manager->persist($season);
      $this->addReference($seasonData['name'].'-season', $season);
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
    return 5;
  }
}