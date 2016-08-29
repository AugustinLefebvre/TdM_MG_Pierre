<?php

namespace MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MapBundle\Entity\Points;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PointController extends Controller
{
	public function createPointViewAction()
	{
		$em=$this->getDoctrine()->getManager();
        $points=$em->getRepository('MapBundle:Points')->findAll();

        return $this->render('MapBundle:Default:newpoint.html.twig', array('points'=>$points));
	}

	public function newPointAction (Request $request)
	{
		$em=$this->getDoctrine()->getManager();
		
		$name = $request->request->get('pointname');
		$lat = $request->request->get('pointlat');
		$lng = $request->request->get('pointlng');

		if(!empty($name))
		{
			$newpoint= new Points();
			$newpoint->setLat($lat);
			$newpoint->setLng($lng);
			$newpoint->setName($name);

			$em->persist($newpoint);
			$em->flush();
		}
		
		$url = $this -> generateUrl('newpoint_view');
        $response = new RedirectResponse($url);
        return $response;
	}
	public function newLocationAction (Request $request)
	{
		$em=$this->getDoctrine()->getManager();
		$location=$em->getRepository('MapBundle:Location')->findOneById(1);
		$newlocation=$request->request->get('newlocation');
		if(!empty($newlocation))
		{
			$location->setPlace($newlocation);
			$em->persist($location);
			$em->flush();
			
			$url = $this -> generateUrl('accueil');
        	$response = new RedirectResponse($url);
        	return $response;
		}
		return $this->render('MapBundle:Default:location.html.twig');
	}
}