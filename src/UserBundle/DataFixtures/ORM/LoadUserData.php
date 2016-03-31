<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
  /**
   * @var ContainerInterface
   */
  private $container;
  private $nbUser = 50;
  private $nbSeries = 45;

  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }

  private function randomizeUser($id) {

    $user = new User();

    $user->setUsername('user n' . $id);
    $user->setEnabled(true);

    $user->setPlainPassword('1234');

    $user->setFirstname('user n' . $id);
    $user->setLastname('user n' . $id);

    $years = rand(1950, 2005);
    $month = rand(1, 12);
    $day = rand(1, 28);
    $dateBirth = new \DateTime($years . '-' . $month . '-' . $day);
    $user->setDayOfBirth($dateBirth);

    $user->setAvatar($this->getReference('serie-image'));

    $user->setEmail('usern' . $id . '@free.fr');
    $roles = [
      ['ROLE_USER', 'ROLE_MODERATOR', 'ROLE_ADMIN'],
      ['ROLE_USER', 'ROLE_MODERATOR'],
      ['ROLE_USER'],
    ];
    $user->setRoles($roles[rand(0, 2)]);

    $follows = array();
    $nbFollow = rand(0, 10);
    for($kk = 0; $kk<$nbFollow; $kk++) {
      do {
        $idSerie = rand(1, $this->nbSeries);
      } while(in_array($idSerie, $follows));
      $follows[] = $idSerie;
    }

    // each Follow
    foreach($follows as $serieFollowed) {
      $user->addSeriesFollowed($this->getReference($serieFollowed . '-serie'));
    }

    $seens = array();
    $nbSeen = rand(0, 9);
    for($kk = 0; $kk<$nbSeen; $kk++) {
      do {
        $idSerie = rand(1, $this->nbSeries);
      } while(in_array($idSerie, $seens));
      $seens[] = $idSerie;
    }

    // each see
    foreach($seens as $serieSeen) {
      $user->addSeriesSeen($this->getReference($serieSeen . '-serie'));
    }

    $this->addReference($id .'-user', $user);
    return $user;
  }

  public function load(ObjectManager $manager)
  {


    for($ii = 1; $ii<=$this->nbUser; $ii++) {
      $user = $this->randomizeUser($ii);
      $manager->persist($user);
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
    return 6;
  }
}