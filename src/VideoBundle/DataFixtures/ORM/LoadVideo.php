<?php
namespace VideoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VideoBundle\Entity\Video;

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
    $video2->setDate(new \DateTime("2016-10-02 12:12:33"));
    $video2->setRealisator('David Cronenberg');

    $video3 = new Video();
    $video3->setTitle('Hot Fuzz');
    $video3->setDate(new \DateTime("2016-11-12 09:12:33"));
    $video3->setRealisator('Edgar Wright');

    $video4 = new Video();
    $video4->setTitle('Dracula');
    $video4->setDate(new \DateTime("2011-01-10 19:10:43"));
    $video4->setRealisator('Francis Ford Copolla');

    $video5 = new Video();
    $video5->setTitle('Sonatine');
    $video5->setDate(new \DateTime("2009-08-07 06:02:13"));
    $video5->setRealisator('Takeshi Kitano');

    $video6 = new Video();
    $video6->setTitle('Videodrome');
    $video6->setDate(new \DateTime("2009-08-07 06:02:13"));
    $video6->setRealisator('David Cronenberg');

    $manager->persist($video);
    $manager->persist($video2);
    $manager->persist($video3);
    $manager->persist($video4);
    $manager->persist($video5);
    $manager->persist($video6);

    $manager->flush();
  }
}
