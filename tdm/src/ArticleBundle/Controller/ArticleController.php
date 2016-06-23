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
use ArticleBundle\Form\PhotosType;

class ArticleController extends Controller
{
    public function articleShowAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();
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
        return $this->render('default/articles.html.twig', array(
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
        $nom_photo = $request->request->get('nom_photo'); 
        
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
      public function newphotoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $photos = new Photos();
        $form = $this->createForm('ArticleBundle\Form\PhotosType', $photos);
        $form->handleRequest($request);

        if ($form->isValid()) {
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

            $em->persist($photos);
            $em->flush();
        }

        return $this->render('/default/newphoto.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function articlespublicsShowAction ()
    {
$em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();
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
        return $this->render('default/articlespublics.html.twig', array(
            'articles' => $articles,
            'photos' => $photos,
            'tab' => $tab,
            'tabphoto'=>$tabphoto,
            'compteur'=>$compteur,
            ));
    }
}
