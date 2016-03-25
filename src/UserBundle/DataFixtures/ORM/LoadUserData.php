<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $users = [
      [
        'username' => 'superMan',
        'password' => 'aaaa',
        'firstname' => 'Jean',
        'lastname' => 'Bernard',
        'dayOfBirth' => new \DateTime('1990-02-14'),
        'email' => 'superMan@test.fr',
        'roles' => ['ROLE_USER', 'ROLE_MODERATOR', 'ROLE_ADMIN'],
        'follow' => ['Louis la Brocante', 'Breaking Bad'],
        'see' => ['Fan fan la tulipe', 'Green'],
      ],
      [
        'username' => 'darkLegolas666',
        'password' => 'aaaa',
        'firstname' => 'Henry',
        'lastname' => 'Martin',
        'dayOfBirth' => new \DateTime('1996-10-25'),
        'email' => 'darkLegolas666@test.fr',
        'roles' => ['ROLE_USER', 'ROLE_MODERATOR'],
        'follow' => ['Breaking Bad'],
        'see' => ['Fan fan la tulipe', 'Green', 'Breaking Bad'],
      ],
      [
        'username' => 'guiGuiLeBof',
        'password' => 'aaaa',
        'firstname' => 'Guillaume',
        'lastname' => 'Orain',
        'dayOfBirth' => new \DateTime('1986-06-27'),
        'email' => 'guiGuiLeBof@test.fr',
        'roles' => ['ROLE_USER'],
        'follow' => ['Louis la Brocante', 'Breaking Bad'],
        'see' => ['Grand Papa'],
      ]
    ];
    // each Users
    foreach($users as $userData) {
      $user = new User();
      $user->setUsername($userData['username']);
      $user->setPassword($userData['password']);
      $user->setFirstname($userData['firstname']);
      $user->setLastname($userData['lastname']);
      $user->setDayOfBirth($userData['dayOfBirth']);
      $user->setAvatar($this->getReference('serie-image'));

      $user->setEmail($userData['email']);
      $user->setRoles($userData['roles']);

      // each Follow
      foreach($userData['follow'] as $serieFollowed) {
        $user->addSeriesFollowed($this->getReference($serieFollowed . '-serie'));
      }

      // each see
      foreach($userData['see'] as $serieSeen) {
        $user->addSeriesSeen($this->getReference($serieSeen . '-serie'));
      }

      $manager->persist($user);
      $this->addReference($userData['username'].'-user', $user);
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