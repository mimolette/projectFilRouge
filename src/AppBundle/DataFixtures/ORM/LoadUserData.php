<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

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
        'avatar' => 'wf_img.jpg',
        'email' => 'superMan@test.fr',
        'roles' => ['ROLE_USER', 'ROLE_MODERATOR', 'ROLE_ADMIN']
      ],
      [
        'username' => 'darkLegolas666',
        'password' => 'aaaa',
        'firstname' => 'Henry',
        'lastname' => 'Martin',
        'dayOfBirth' => new \DateTime('1996-10-25'),
        'avatar' => 'wf_img.jpg',
        'email' => 'darkLegolas666@test.fr',
        'roles' => ['ROLE_USER', 'ROLE_MODERATOR']
      ],
      [
        'username' => 'guiGuiLeBof',
        'password' => 'aaaa',
        'firstname' => 'Guillaume',
        'lastname' => 'Orain',
        'dayOfBirth' => new \DateTime('1986-06-27'),
        'avatar' => 'wf_img.jpg',
        'email' => 'guiGuiLeBof@test.fr',
        'roles' => ['ROLE_USER']
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
      $user->setAvatar($userData['avatar']);

      $user->setEmail($userData['email']);
      $user->setRoles($userData['roles']);

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
    return 1;
  }
}