<?php

namespace SerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SerieBundle:Default:index.html.twig');
    }

    public function top10Action()
    {
        return $this->render('SerieBundle:Default:top10.html.twig');
    }
}
