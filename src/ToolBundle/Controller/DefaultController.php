<?php

namespace ToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ToolBundle\Entity\Evaluate;
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

    private function checkUserScore($serieId) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getRepository('ToolBundle:Evaluate');

        return $em->checkValid($user->getId(), $serieId);

    }

    /**
     * @param $id
     * @param $note
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function scoreAction($id, $note, Request $request) {
        $note = $note > 5 ? 5 : $note;
        $note = $note < 0 ? 0 : $note;
        $em = $this->getDoctrine()->getEntityManager();
        $serie = $this->getDoctrine()->getRepository('SerieBundle:Serie')->find($id);


        if(!$this->checkUserScore($id)) {
            $valid = true;
            $evaluation = new Evaluate();
            $evaluation->setUser($this->getUser());
            $evaluation->setSerie($serie);
            $evaluation->setScore($note);

            $em->persist($evaluation);
            $em->flush();

        }

        return $this->redirect($request->headers->get('referer'));
    }
}
