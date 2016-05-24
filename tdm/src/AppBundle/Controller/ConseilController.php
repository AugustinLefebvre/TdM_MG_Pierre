<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conseil;

class ConseilController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function conseilShowAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/conseil.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    public function conseilSendAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nom = $request->request->get('nom');
        $email = $request->request->get('email');
        $motif = $request->request->get('motif');
        $content = $request->request->get('conseil');

        $conseil = new Conseil();
        $conseil->setNom($nom);
        $conseil->setEmail($email);
        $conseil->setMotif($motif);
        $conseil->setContent($content);

        $em->persist($conseil);
        $em->flush();

        return $this->render('default/conseilcheck.html.twig', array(
            'conseil' => $conseil
        ));     
    }
    public function conseilViewAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $conseil=$em->getRepository('AppBundle:Conseil')->findAll();
        
        return $this->render('default/conseilview.html.twig', array(
            'conseils' => $conseil
        ));     
    }
}
