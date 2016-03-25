<?php

namespace SerieBundle\Controller;

use ToolBundle\Entity\Image;
use SerieBundle\Entity\Serie;
use SerieBundle\Form\SerieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // find all catagories
        $categories = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Category")
            ->findAll();


        $finalResult = [];
        // first : find the five best series by average score
        $series = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->getXSeriesByAvgScore();

        // then : loop all the five series find to looking for the best comment of each serie
        foreach($series as $serie) {
            $bestComment = $this
                ->getDoctrine()
                ->getRepository("ToolBundle:Comment")
                ->getBestCommentBySerieId($serie[0]->getId());
            // end : make a single result for each serie including the comment and his number of
            // like en dislike
            $serie['comment'] = $bestComment[0];
            $serie['nbViewers'] = $serie[0]->getViewers()->count();
            $serie['nbLike'] = $bestComment['nbLike'];
            $serie['nbDislike'] = $bestComment[0]->getNbDislikes($serie['nbLike']);
            // push the result in the final array
            $finalResult[] = $serie;
        }
        return $this->render('SerieBundle:Default:index.html.twig', array(
            'series' => $finalResult,
            'categories' => $categories
        ));
    }

    public function top10Action()
    {
        $em = $this->getDoctrine()->getManager();
        $series = $em->getRepository("SerieBundle:Serie")->findBy(array(), null, 10);
        return $this->render('SerieBundle:Default:top10.html.twig',["series" => $series]);
    }

    public function detailAction($id)
    {
        $serie = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->find($id);

        return $this->render('SerieBundle:Default:detail.html.twig', ["serie" => $serie]);
    }

    public function addAction(Request $request)
    {


        $serie = new Serie();
        $form = $this->createForm(new SerieType() ,$serie);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() )
        {
            $img = new Image($serie->getPoster());
            $img->upload();
            $serie->setPoster($img);
            $em = $this->getDoctrine()->getManager();
            $em->persist($serie);
            $em->flush();
            return $this->redirectToRoute('serie_homepage');
        }

        return $this->render('SerieBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
            'action' => 'ajouter',
        ));
    }

    public function delAction(Serie $serie)
    {
        if(null === $serie){
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($serie);
        $em->flush();

        return $this->redirectToRoute('serie_homepage');
    }

    public function modAction(Request $request,$id)
    {

        $serie = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->find($id);
        if ($serie == null) return $this->redirectToRoute('serie_homepage');
        $form = $this->createForm(new SerieType() ,$serie);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() )
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($serie);
            $em->flush();
            return $this->redirectToRoute('serie_homepage');
        }

        return $this->render('SerieBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
            'action' => 'modifier',
        ));
    }

    public function listAction()
    {
        $series = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->getXSeriesByNbViewers();

        var_dump($series);
        die();

        return $this->render('SerieBundle:Default:list.html.twig');
    }

    public function listCategoryAction($id) {

        $series = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->getXSeriesByCategory($id);
        var_dump($series);
        die();

        return $this->render('SerieBundle:Default:list.html.twig');
    }

    public function searchAction()
    {

        return $this->render('SerieBundle:Default:list.html.twig');
    }
}
