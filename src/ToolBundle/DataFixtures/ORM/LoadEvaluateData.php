<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\Evaluate;

class LoadEvaluateData extends AbstractFixture implements OrderedFixtureInterface
{

  private $nbSeries = 45;
  private $nbUsers = 50;
  private $min = 1;
  private $max = 5;

  private function randomizeEval($userId, $serieId) {
    $eval = new Evaluate();
    $eval->setScore(rand($this->min, $this->max));
    $eval->setUser($this->getReference($userId . '-user'));
    $eval->setSerie($this->getReference($serieId . '-serie'));


    return $eval;
  }

  public function load(ObjectManager $manager)
  {

    for($idUser = 1; $idUser <= $this->nbUsers; $idUser++) {
      $randNbEval = rand(0, 15);
      $series = array();
      for($jj = 0; $jj<$randNbEval; $jj++) {
        do {
          $idSerie = rand(1, $this->nbSeries);
        } while(in_array($idSerie, $series));
        $series[] = $idSerie;
      }
      foreach($series as $idSerie) {
        $eval = $this->randomizeEval($idUser, $idSerie);
        $manager->persist($eval);
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
    return 8;
  }
}