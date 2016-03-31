<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Season;

class LoadSeasonData extends AbstractFixture implements OrderedFixtureInterface
{

    private $nbSerie = 45;
    private $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

  private function randomizeSaison($id, $serieId, $num) {

    $season = new Season();
    $season->setName('saison n' . $id);
    $season->setNum($num);
    $season->setSerie($this->getReference($serieId.'-serie'));

    $this->addReference($id.'-season', $season);

    return $season;
  }

  public function load(ObjectManager $manager)
  {
    $id = 0;

    for($ii = 1; $ii<=$this->nbSerie; $ii++) {

      $randNbSeason = rand(1, 8);
      for($numSeason = 1; $numSeason<=$randNbSeason; $numSeason++) {
        $season = $this->randomizeSaison($id, $ii, $numSeason);
        $manager->persist($season);
        $id++;
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
    return 4;
  }
}