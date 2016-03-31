<?php

namespace ToolBundle\Controller;

use ToolBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('ToolBundle:Default:index.html.twig');
    }

    /**
     * @Route("/comment/add",name="comment_add")
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->find($request->request->get('id'));

    	$postdate = new \DateTime();
    	$comment = new Comment();
    	$comment->setMessage($request->request->get('comment')['message']);
    	$comment->setPostDate($postdate);
    	$comment->setSerie($serie);
    	$comment->setUser($this->getUser());

        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('serie_detail', array('id'=>$request->request->get('id')));
    }
}
