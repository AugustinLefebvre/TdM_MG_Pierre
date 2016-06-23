<?php

namespace PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhotoController extends Controller
{
    public function showPhotoAction ()
    {
    	$compte=0;
    	$em=$this->getDoctrine()->getManager();
    	$articles = $em->getRepository('ArticleBundle:Article')->findAll();
    	 if(!empty($articles))
    	 {
    	 	foreach ($articles as $article)
            {
            	$idarticle=$article->getId();
       			$photo= $em->getRepository('ArticleBundle:Photos')->findOneByIdArticle($idarticle);
    			if(!empty($photo))
        		{	
                	$tabphoto[]= array(
                    	'nom'=>$photo->getNom(),
                    	'path'=>$photo->getPath(),
                    	'id'=>$photo->getIdArticle(),
                    	'titre'=>$article->getTitre(),
                    );
                   	$compte++;
                }
            }
        }
    	return $this->render('PhotoBundle:Default:photolist.html.twig', array(
    		'photos'=>$tabphoto,
    		'compte'=>$compte,
    		));
    }
    public function showPhotosAction ($id)
    {
    	$compte=0;
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('ArticleBundle:Article')->findOneById($id);
        $photos = $em->getRepository('ArticleBundle:Photos')->findByIdArticle($id);
        foreach ($photos as $photo)
            {
                $tabphoto[]= array(
                	'titre'=>$article->getTitre(),
                    'nom'=>$photo->getNom(),
                    'path'=>$photo->getPath(),
                    'idArticle'=>$photo->getIdArticle(),
                    );
                $compte++;
            }
            if(empty($tabphoto))
                {
                	$tabphoto=0;
                }
        return $this->render('PhotoBundle:Default:articlephotos.html.twig', array(
            'article'=>$article,
            'photos'=>$tabphoto,
            'compte'=>$compte,
        ));
    }
}
