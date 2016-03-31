<?php

namespace ToolBundle\Controller;

use ToolBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use ToolBundle\Entity\LikeDislike;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @param $id
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function likeAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $comment = $this->getDoctrine()->getRepository('ToolBundle:Comment')->find($id);
        $valid = false;

        if(!$this->checkUserComment($id)) {
            $valid = true;
            $likeDislike = new LikeDislike();
            $likeDislike->setUser($this->getUser());
            $likeDislike->setComment($comment);
            $likeDislike->setLikeIt(true);

            $em->persist($likeDislike);
            $em->flush();
        }

        $response = new Response(json_encode(array(
            'valid' => $valid
            )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $comment = $this->getDoctrine()->getRepository('ToolBundle:Comment')->find($id);
        $valid = false;

        if(!$this->checkUserComment($id)) {
            $valid = true;
            $likeDislike = new LikeDislike();
            $likeDislike->setUser($this->getUser());
            $likeDislike->setComment($comment);
            $likeDislike->setLikeIt(false);

            $em->persist($likeDislike);
            $em->flush();
        }

        $response = new Response(json_encode(array(
            'valid' => $valid
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function checkUserComment($commentId) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getRepository('ToolBundle:LikeDislike');

        return $em->checkValid($user->getId(), $commentId);

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
