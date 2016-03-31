<?php

namespace SerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Episode;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Exception\OutOfBoundsException;

class LoadEpisodeData extends AbstractFixture implements OrderedFixtureInterface
{

  private $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

  private function randomizeEpisode($id, $season, $num) {

    $curentDate = new \DateTime('2015-03-26');

    $episode = new Episode();
    $episode->setName('Episode n°' . ($num));
    $episode->setSynopsis($this->lorem);
    $episode->setNum($num);
    $episode->setReleaseDate(new \DateTime($curentDate->format('Y-m-d')));
    $episode->setSeason($season);


    return $episode;
  }

  public function load(ObjectManager $manager)
  {
    $season = $manager->getRepository('SerieBundle:Season')->findAll();

    $idSeason = 1;
    $idEpisode = 1;

    foreach($season as $ss) {
        $nbEpisodes = rand(10, 20);
        for($ii = 1; $ii <= $nbEpisodes; $ii++) {
          $episode = $this->randomizeEpisode($idEpisode, $ss, $ii);

          $manager->persist($episode);
        }
    }

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