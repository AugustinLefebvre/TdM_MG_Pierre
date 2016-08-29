<?php

namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\Photos;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ArticleController extends Controller
{
    public function articleShowAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findBy(array(),array('id'=>'desc') );
        $photos=$em->getRepository('ArticleBundle:Photos')->findAll();
        $compteur=-1;
        foreach ($articles as $article)
        {
            $photos=$em->getRepository('ArticleBundle:Photos')->findByIdArticle($article->getId());
            foreach ($photos as $photo)
            {
                $tabphoto[]= array(
                    'nom'=>$photo->getNom(),
                    'path'=>$photo->getPath(),
                    'idArticle'=>$photo->getIdArticle(),
                    );
                $compteur= $compteur+1;
            }
             
            $tab[]= array(
                'id'=>$article->getId(),
                'titre'=>$article->getTitre(),
                'date'=>$article->getDate(),

                );
        }
        if (empty($tab))
        {
            $tab=1;
        }
        if (empty($tabphoto))
        {
            $tabphoto=1;
        }
        return $this->render('ArticleBundle:Default:articles.html.twig', array(
            'articles' => $articles,
            'photos' => $photos,
            'tab' => $tab,
            'tabphoto'=>$tabphoto,
            'compteur'=>$compteur,
            ));
    }
    

    public function articleCreateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $titre = $request->request->get('titre');
        $contenu = $request->request->get('contenu');
        #photos de l'article
        // $nom_photo = $request->request->get('nom_photo'); 
        
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


    public function articlespublicsShowAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findBy(array(),array('id'=>'desc') );
        $photos=$em->getRepository('ArticleBundle:Photos')->findAll();
        $compteur=-1;
        foreach ($articles as $article)
        {
            $photos=$em->getRepository('ArticleBundle:Photos')->findByIdArticle($article->getId());
            foreach ($photos as $photo)
            {
                $tabphoto[]= array(
                    'nom'=>$photo->getNom(),
                    'path'=>$photo->getPath(),
                    'idArticle'=>$photo->getIdArticle(),
                    );
                $compteur= $compteur+1;
            }
            
            $tab[]=array(
                'id'=>$article->getId(),
                'titre'=>$article->getTitre(),
                'date'=>$article->getDate(),

                );
        }
        if (empty($tab))
        {
            $tab=1;
        }
        if (empty($tabphoto))
        {
            $tabphoto=1;
        }
            
        return $this->render('ArticleBundle:Default:articlespublics.html.twig', array(
            'articles' => $articles,
            'photos' => $photos,
            'tab' => $tab,
            'tabphoto'=>$tabphoto,
            'compteur'=>$compteur,
            ));
    }

    public function oneArticleAction ($id)
    {
        $em=$this->getDoctrine()->getManager();

        $article=$em->getRepository('ArticleBundle:Article')->findOneById($id);
        $photos=$em->getRepository('ArticleBundle:Photos')->findByIdArticle($id);
        
        return $this->render('ArticleBundle:Default:onearticle.html.twig',array(
            "article"=>$article,
            "photos"=>$photos,
            ));
    }

    public function removeArticleShowAction ()
    {
        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();

        return $this->render('ArticleBundle:Default:removearticle.html.twig', array(
            'articles'=>$articles,
            ));
    }
    public function removeArticleAction (Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $articlename=$request->request->get('articlename');

        if(!empty($articlename))
        {
            $article=$em->getRepository('ArticleBundle:Article')->findOneByTitre($articlename);
            $em->remove($article);
            $em->flush();
        }
        $url = $this -> generateUrl('article_show');
        $response = new RedirectResponse($url);
        return $response;
    }
}
