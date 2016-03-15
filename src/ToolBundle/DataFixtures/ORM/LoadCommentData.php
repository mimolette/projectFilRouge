<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\Comment;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $min = 50;
    $max = 500;

    $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque imperdiet pulvinar ligula sed tincidunt. Aliquam quis semper ante. In interdum, eros id vestibulum consequat, magna lorem lobortis lectus, auctor vulputate enim est eget ligula. Donec viverra, neque imperdiet condimentum tincidunt, lorem erat porttitor ex, et aliquet massa eros vitae lorem. Nam in ligula efficitur, posuere nibh eget, pulvinar erat. Cras purus ipsum, pulvinar ut bibendum ac, pellentesque id lacus. Donec et sed.';

    $users = [
      'superMan-user',
      'darkLegolas666-user',
      'guiGuiLeBof-user'
    ];

    $series = [
      [
        'ref' => 'Louis la Brocante-serie',
        'nbCom' => 8,
        'date' => '2016-02-08'
      ],
      [
        'ref' => 'Fan fan la tulipe-serie',
        'nbCom' => 14,
        'date' => '2016-02-09'
      ],
      [
        'ref' => 'Breaking Bad-serie',
        'nbCom' => 4,
        'date' => '2016-02-14'
      ],
      [
        'ref' => 'Green-serie',
        'nbCom' => 19,
        'date' => '2016-02-20'
      ],
      [
        'ref' => 'Grand Papa-serie',
        'nbCom' => 11,
        'date' => '2016-02-27'
      ],
    ];

    // each series
    foreach($series as $serieData) {

      for ($ii = 0; $ii < $serieData['nbCom']; $ii++) {
        $com = new Comment();
        $dateCom = new \DateTime($serieData['date']);
        $dateCom->setTime(rand(0,23), rand(0,59), rand(0,59));
        $com->setPostDate(\DateTime::createFromFormat('Y-m-d:H:m:s', $dateCom->format('Y-m-d:H:m:s')));
        $com->setMessage(substr($lorem, 0, rand(50, 500)));
        $com->setValidation(rand(0, 1));
        $com->setUser($this->getReference($users[rand(0,2)]));
        $com->setSerie($this->getReference($serieData['ref']));

        $manager->persist($com);
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
    return 7;
  }
}