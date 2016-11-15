<?php
namespace VideoBundle\Factory;
use Doctrine\ORM\EntityManager;
use VideoBundle\Entity\Video;

class VideoFactory
{

	protected $em;

	public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

	public function createVideo($title, $date, $realisator){

		$video = new Video();
		$video->setTitle($title);
		$video->setDate($date);
		$video->setRealisator($realisator);
		$this->em->persist($video);
		$this->em->flush();
	}
}