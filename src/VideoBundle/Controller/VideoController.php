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

class VideoController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/videos")
     * @QueryParam(name="from", requirements="^\d{8}$", default="", description="A partir de quand afficher les éléments")
     * @QueryParam(name="to", requirements="^\d{8}$", default="", description="Limite d'éléments à afficher")
     * @QueryParam(name="realisator", default="", description="Nom du réalisateur")
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
            $qb->where('v.realisator = :realisator')
            ->setParameter('realisator', $realisator);
        }

        if ($from != "" && $to != "") {
        	$qb->where('v.date BETWEEN :from AND :to')
        	->setParameter('from', $from)
            ->setParameter('to', $to);
        }

        $videos = $qb->getQuery()->getResult();
        $json = json_decode($videos);
		return json_encode($json, JSON_PRETTY_PRINT);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/videos/{id}")
     */
    public function getVideoAction($id)
    {

        $video = $this->get('doctrine.orm.entity_manager')
                ->getRepository('VideoBundle:Video')
                ->find($id);

    /*  $view = View::create($videos);
        $view->setFormat('json');

        return $view;*/
        return $video;
    }
}
