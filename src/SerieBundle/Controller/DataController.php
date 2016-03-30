<?php

namespace SerieBundle\Controller;

use SerieBundle\Entity\Serie;
use SerieBundle\Form\SerieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ToolBundle\Entity\Image;

class DataController extends Controller
{
  public function categoriesAction()
  {
    // find all catagories
    $categories = $this
        ->getDoctrine()
        ->getRepository("SerieBundle:Category")
        ->findAll();

    return $this->render('::default/categories.html.twig', array(
        'categories' => $categories
    ));
  }

}
