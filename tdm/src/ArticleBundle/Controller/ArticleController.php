<?php

namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ArticleBundle\Entity\Article;
use DateTime;

class ArticleController extends Controller
{
    public function articleShowAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();

        return $this->render('default/articles.html.twig', array(
        	'articles' => $articles,
        	));
    }
    
    public function articleCreateAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$titre = $request->request->get('titre');
    	$contenu = $request->request->get('contenu');
    	
    	if (!empty($titre) && !empty($contenu))
	    {
	    	$article = new Article();
	    	$article->setTitre($titre);
	    	$article->setDate(new Datetime());
	    	$article->setContenu($contenu);
    	    $em->persist($article);
            $em->flush();
        }

    	
     	$url = $this -> generateUrl('article_show');
        $response = new RedirectResponse($url);
        return $response;

    }
}
