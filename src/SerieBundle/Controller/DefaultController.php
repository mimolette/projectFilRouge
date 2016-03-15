<?php

namespace SerieBundle\Controller;

use SerieBundle\Entity\Serie;
use SerieBundle\Form\SerieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $series = $em->getRepository("SerieBundle:Serie")->findBy(array(), null, 5);
        return $this->render('SerieBundle:Default:index.html.twig',["series" => $series]);
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($serie);
            $em->flush();
            return $this->redirectToRoute('serie_list');
        }

        return $this->render('SerieBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function delAction($id)
    {
        $serie = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        if(null === $serie){
            throw $this->createNotFoundException();
        }

        $em->remove($serie);
        $em->flush();

        return $this->redirectToRoute('serie_homepage');
    }

    public function listAction()
    {
        return $this->render('SerieBundle:Default:list.html.twig');
    }
}
