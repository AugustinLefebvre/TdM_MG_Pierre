<?php

namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\Photos;
use DateTime;

class ArticleController extends Controller
{
    public function articleShowAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();
        $photos=$em->getRepository('ArticleBundle:Photos')->findAll();
        foreach ($articles as $article)
        {

            $photo=$em->getRepository('ArticleBundle:Photos')->findOneByIdArticle($article->getId());
            if(!empty($photo)){$url=$photo->getUrl();}else{$url=1;}
            $tab[]=array(
                'id'=>$article->getId(),
                'titre'=>$article->getTitre(),
                'date'=>$article->getDate(),
                'url'=>$url
                );
        }

        return $this->render('default/articles.html.twig', array(
        	'articles' => $articles,
            'photos' => $photos,
            'tab' => $tab,
        	));
    }
    
    public function articleCreateAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$titre = $request->request->get('titre');
    	$contenu = $request->request->get('contenu');
#photos de l'article
    	$nom_photo = $request->request->get('nom_photo');
        $url = $request->request->get('url'); 
    	
        if (!empty($titre) && !empty($contenu))
	    {
	    	$article = new Article();
	    	$article->setTitre($titre);
	    	$article->setDate(new Datetime());
	    	$article->setContenu($contenu);
    	    $em->persist($article);
            $em->flush();
        }
        if (!empty($url))
        {
            $photos = new Photos();
            $photos->setNom($nom_photo);
            $photos->setUrl($url);
            $photos->setIdArticle($article->getId());
            $em->persist($photos);
            $em->flush();
        }
    	
     	$url = $this -> generateUrl('article_show');
        $response = new RedirectResponse($url);
        return $response;

    }
    public function articlespublicsShowAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();
        $photos=$em->getRepository('ArticleBundle:Photos')->findAll();
        
        foreach ($articles as $article)
        {
            $photo=$em->getRepository('ArticleBundle:Photos')->findOneByIdArticle($article->getId());
            if(!empty($photo)){$url=$photo->getUrl();}else{$url=1;}
            $tab[]=array(
                'id'=>$article->getId(),
                'titre'=>$article->getTitre(),
                'date'=>$article->getDate(),
                'url'=>$url
                );
        }

        return $this->render('default/articlespublics.html.twig', array(
            'articles' => $articles,
            'photos' => $photos,
            'tab' => $tab,
            ));
    }
}
