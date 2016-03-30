<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\Evaluate;

class LoadEvaluateData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $min = 1;
    $max = 5;

    $users = [
        'superMan-user',
        'darkLegolas666-user',
        'guiGuiLeBof-user'
    ];

    $series = [
        [
            'ref' => 'Louis la Brocante-serie',
            'nbEval' => 11,
        ],
        [
            'ref' => 'Fan fan la tulipe-serie',
            'nbEval' => 26,
        ],
        [
            'ref' => 'Breaking Bad-serie',
            'nbEval' => 56,
        ],
        [
            'ref' => 'Green-serie',
            'nbEval' => 4,
        ],
        [
            'ref' => 'Grand Papa-serie',
            'nbEval' => 10,
        ],
    ];

    // each series
    foreach($series as $serieData) {

      for ($ii = 0; $ii < $serieData['nbEval']; $ii++) {
        $eval = new Evaluate();
        $eval->setScore(rand($min, $max));
        $eval->setUser($this->getReference($users[rand(0,2)]));
        $eval->setSerie($this->getReference($serieData['ref']));

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