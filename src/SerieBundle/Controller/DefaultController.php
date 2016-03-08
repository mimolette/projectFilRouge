<?php

namespace SerieBundle\Controller;

use SerieBundle\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        return $this->render('SerieBundle:Default:top10.html.twig');
    }

    public function detailAction($id)
    {
        $serie = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->find($id);

        return $this->render('SerieBundle:Default:detail.html.twig', ["serie" => $serie]);
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
