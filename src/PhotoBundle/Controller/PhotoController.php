<?php

namespace PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\Photos;
use ArticleBundle\Form\PhotosType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    public function newPhotoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository('ArticleBundle:Article')->findAll();
        $photos = new Photos();

        $form = $this->createForm('ArticleBundle\Form\PhotosType', $photos);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $idarticle=$em->getRepository('ArticleBundle:Article')->findOneByTitre($idArticle=$request->request->get('idarticle'))->getId();
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $photos->getPath();

            // Generate a unique name for the file before saving it
            $path = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where images are stored
            $pathDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/pictures';
            $file->move($pathDir, $path);

            // Update the 'path' property to store the PDF file name
            // instead of its contents
            $photos->setPath($path);

            // ... persist the $article variable or any other work
            $photos->setIdArticle($idarticle);

            $em->persist($photos);
            $em->flush();
        }
        return $this->render('PhotoBundle:Default:newphoto.html.twig', array(
            'form' => $form->createView(),
            'articles'=>$article
        ));
    }
}
