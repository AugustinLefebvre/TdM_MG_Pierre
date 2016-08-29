<?php

namespace ViewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $points=$em->getRepository('MapBundle:Points')->findAll();
        $location = $em->getRepository('MapBundle:Location')->findOneById(1)->getPlace();
        return $this->render('ViewsBundle:Default:index.html.twig', array('points'=>$points, 'location'=>$location));
    }
}
