<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Serie;

class LoadSerieData extends AbstractFixture implements OrderedFixtureInterface
{

  private $nbActors = 150;
  private $nbSerie = 45;
  private $nbCategories = 12;
  private $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

  private function randomizeSerie($id) {
    $serie = new Serie();
    $serie->setName('serie n' . $id);
    $serie->setSynopsis($this->lorem);
    $serie->setPoster($this->getReference('serie-image'));
    $serie->setValidation(true);
    // each actors
    $actors = array();
    $nbActors = rand(2, 8);
    for($jj = 0; $jj<$nbActors; $jj++) {
      do {
        $idActor = rand(1, $this->nbActors);
      } while(in_array($idActor, $actors));
      $actors[] = $idActor;
    }
    foreach($actors as $actor) {
      $serie->addActor($this->getReference($actor.'-actor'));
    }

    $cats = array();
    $nbCats = rand(1, 3);
    for($kk = 0; $kk<$nbCats; $kk++) {
      do {
        $idCat = rand(1, $this->nbCategories);
      } while(in_array($idCat, $cats));
      $cats[] = $idCat;
    }
    // each category
    foreach($cats as $cat) {
      $serie->addCategory($this->getReference($cat.'-cat'));
    }

    $this->addReference($id.'-serie', $serie);
    return $serie;
  }

  public function load(ObjectManager $manager)
  {

    for($ii = 1; $ii<=$this->nbSerie; $ii++) {
      $serie = $this->randomizeSerie($ii);
      $manager->persist($serie);
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
    return 3;
  }
}