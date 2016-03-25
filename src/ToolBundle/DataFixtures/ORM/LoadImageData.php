<?php

namespace ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ToolBundle\Entity\Image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $image = new Image();
    $image->setPath('wf_img.jpg');

    $manager->persist($image);
    $this->setReference('serie-image', $image);

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