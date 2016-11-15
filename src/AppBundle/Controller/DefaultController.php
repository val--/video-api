<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
/*    	$videoFactory = $this->get('video.factory');
    	$videoFactory->CreateVideo('Test', new \DateTime("2016-09-23 06:12:33"), 'bidule');*/
        return $this->render('AppBundle:Default:index.html.twig');
    }
}
