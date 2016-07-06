<?php

namespace ConseilBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ConseilBundle\Entity\Conseil;

class ConseilController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function conseilShowAction()
    {
        // replace this example code with whatever you need
        return $this->render('ConseilBundle:Default:conseil.html.twig', array(
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
        $conseil->setContenu($content);

        $em->persist($conseil);
        $em->flush();

        return $this->render('ConseilBundle:Default:conseilcheck.html.twig', array(
            'conseil' => $conseil
        ));     
    }
    public function conseilViewAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $conseil=$em->getRepository('ConseilBundle:Conseil')->findAll();
        
        return $this->render('ConseilBundle:Default:conseilview.html.twig', array(
            'conseils' => $conseil
        ));     
    }
}
