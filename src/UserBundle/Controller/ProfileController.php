<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;


/**
 * Controller managing the user profile
 *
 */
class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction($id)
    {

        $user = $this
            ->getDoctrine()
            ->getRepository("UserBundle:User")
            ->find($id);
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }


        $finalResult = [];
        // first : find comments which belong to user
        $comments = $this
            ->getDoctrine()
            ->getRepository("ToolBundle:Comment")
            ->getCommentsByUserId($id);

        // loop all the comments to get number of like and dislike for each comment
        foreach($comments as $comment) {
            // comment and his number of like and dislike
            $comment['comment'] = $comment[0]->getMessage();
            $comment['postDate'] = $comment[0]->getPostDate();
            $comment['serie'] = $comment[0]->getSerie();
            $comment['nbLike'] = $comment['nbLike'];
            $comment['nbDislike'] = $comment[0]->getNbDislikes($comment['nbLike']);
            // push the result in the final array
            $finalResult[] = $comment;
        }




        return $this->render('UserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'comments' => $finalResult,
        ));



    }



}
