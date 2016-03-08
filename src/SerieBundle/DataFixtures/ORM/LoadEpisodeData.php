<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SerieBundle\Entity\Episode;

class LoadEpisodeData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $synopsis = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labo reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
    $episodes = [
        [
          'season' => 'Long fleuve pas tranquil',
          'nbEpisode' => 14,
          'firstDate' => new \DateTime('2015-03-26'),
          'nextEpisode' => 5
        ],
        [
            'season' => 'Rivière pas pourpre',
            'nbEpisode' => 11,
            'firstDate' => new \DateTime('2015-11-02'),
            'nextEpisode' => 6
        ],
        [
            'season' => 'Chien et chat',
            'nbEpisode' => 9,
            'firstDate' => new \DateTime('2014-02-26'),
            'nextEpisode' => 3
        ],
        [
            'season' => 'Arco',
            'nbEpisode' => 19,
            'firstDate' => new \DateTime('2013-06-01'),
            'nextEpisode' => 7
        ],
        [
            'season' => 'Mange ta soupe',
            'nbEpisode' => 17,
            'firstDate' => new \DateTime('2014-03-01'),
            'nextEpisode' => 7
        ],
        [
            'season' => 'Range ta chambre',
            'nbEpisode' => 13,
            'firstDate' => new \DateTime('2015-01-01'),
            'nextEpisode' => 7
        ],
        [
            'season' => 'Trogodyte',
            'nbEpisode' => 22,
            'firstDate' => new \DateTime('2015-12-01'),
            'nextEpisode' => 7
        ],
        [
            'season' => 'Momo et le chien',
            'nbEpisode' => 9,
            'firstDate' => new \DateTime('2014-09-14'),
            'nextEpisode' => 5
        ],
        [
            'season' => 'Greg et jean',
            'nbEpisode' => 13,
            'firstDate' => new \DateTime('2015-09-01'),
            'nextEpisode' => 6
        ]
    ];

    // each Episodes
    foreach($episodes as $seasonData) {

      $curentDate = $seasonData['firstDate'];

      for($ii=0; $ii<=$seasonData['nbEpisode']; $ii++) {

        $episode = new Episode();
        $episode->setName('Episode n°' . ($ii+1));
        $episode->setSynopsis($synopsis);
        $episode->setNum($ii+1);
        $episode->setReleaseDate(new \DateTime($curentDate->format('Y-m-d')));

        // increase the current date
        $curentDate->modify('+'.$seasonData['nextEpisode'].' day');

        $manager->persist($episode);
      }
//      $episode->setSeason($this->getReference($episodeData['season'].'-season'));

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