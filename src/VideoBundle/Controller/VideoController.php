<?php

namespace VideoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use VideoBundle\Entity\Video;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class VideoController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/videos")
     * @QueryParam(name="from", requirements="^\d{8}$", default="", description="A partir de quand afficher les éléments")
     * @QueryParam(name="to", requirements="^\d{8}$", default="", description="Limite d'éléments à afficher")
     * @QueryParam(name="realisator", default="", description="Nom du réalisateur")
     * @ApiDoc(
     *  resource=true,
     *  description="Returns all the videos."
     * )
     */
    public function getVideosAction(ParamFetcher $paramFetcher)
    {
    	$realisator = $paramFetcher->get('realisator');
    	$from = $paramFetcher->get('from');
    	$to = $paramFetcher->get('to');


        $qb = $this->get('doctrine.orm.entity_manager')->createQueryBuilder();

        $qb->select('v')
           ->from('VideoBundle:Video', 'v');

        if ($realisator != "") {
            $qb->where('v.realisator LIKE :realisator')
            ->setParameter('realisator', $realisator.'%');
        }

        if ($from != "" && $to != "") {
        	$qb->andwhere('v.date BETWEEN :from AND :to')
        	->setParameter('from', $from)
            ->setParameter('to', $to);
        }

        $qbcount = $this->get('doctrine.orm.entity_manager')->createQueryBuilder();
        $count = $qbcount->select('count(v.id)')->from('VideoBundle:Video', 'v')->setMaxResults(1)->getQuery()->getOneOrNullResult();

        $videos = array('Videos' => $qb->getQuery()->getResult(), 'Count' => $count[1]);

        if (empty($videos)) {
            return new JsonResponse(['message' => 'Nothing found !'], Response::HTTP_NOT_FOUND);
        }


        return $videos;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/videos/{id}")
     * @ApiDoc(
     *  description="Returns a video.",
     *  parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="video id"}
     *  },
     *  filters={
     *      {"name"="from", "dataType"="datetime", "description"="Get the videos added from this date"},
            {"name"="to", "dataType"="datetime", "description"="Get the videos added to this date (must be used with FROM parameter above). Ex. '?from=20150101&to=20151231' "},
     *      {"name"="realisator", "dataType"="string", "description" = "All the videos from this realisator. Ex. '?realisator=David '"}
     *  }
     * )
     */
    public function getVideoAction($id)
    {

        $video = $this->get('doctrine.orm.entity_manager')
                ->getRepository('VideoBundle:Video')
                ->find($id);

        if (empty($video)) {
            return new JsonResponse(['message' => 'Video not found'], Response::HTTP_NOT_FOUND);
        }
        return $video;
    }
}
