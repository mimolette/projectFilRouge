<?php

namespace ToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use ToolBundle\Entity\LikeDislike;

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

    /**
     * @param $id
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dislikeAction($id)
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
}
