<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Video;

class DefaultController extends Controller
{
    /**
     * @Route("/videos", name="videos")
     * @Method({"GET"})
     */
    public function getVideosAction(Request $request)
    {
        $videos = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Video')
                ->findAll();

        $formatted = [];

        foreach ($videos as $video) {
            $formatted[] = [
               'id' => $video->getId(),
               'title' => $video->getTitle(),
               'realisator' => $video->getRealisator(),
            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/video/{video_id}", name="video")
     * @Method({"GET"})
     */
    public function getVideoAction(Request $request)
    {
        $video = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Video')
                ->find($request->get('video_id'));

        if (empty($video)) {
            return new JsonResponse(['message' => 'Video not found'], Response::HTTP_NOT_FOUND);
        }
        $formatted = [
           'id' => $video->getId(),
           'title' => $video->getTitle(),
           'realisator' => $video->getRealisator(),
        ];

        return new JsonResponse($formatted);
    }
}
