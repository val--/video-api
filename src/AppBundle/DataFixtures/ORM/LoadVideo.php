<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Video;

class LoadVideo implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $video = new Video();
    $video->setTitle('A Clockwork Orange');
    $video->setDate(new \DateTime("2016-09-23 06:12:33"));
    $video->setRealisator('Stanley Kubrick');

    $video2 = new Video();
    $video2->setTitle('Eastern Promises');
    $video->setDate(new \DateTime("2016-10-02 12:12:33"));
    $video2->setRealisator('David Cronenberg');

    $video3 = new Video();
    $video3->setTitle('Hot Fuzz');
    $video->setDate(new \DateTime("2016-11-12 09:12:33"));
    $video3->setRealisator('Edgar Wright');

    $manager->persist($video);
    $manager->persist($video2);
    $manager->persist($video3);

    $manager->flush();
  }
}
