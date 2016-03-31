<?php

namespace SerieBundle\Controller;

use SerieBundle\Entity\Serie;
use SerieBundle\Form\SerieType;
use ToolBundle\Entity\Comment;
use ToolBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ToolBundle\Entity\Image;

class DefaultController extends Controller
{
    public function indexAction()
    {

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
        ));
    }

    public function top10Action()
    {

        $series = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->getXSeriesByAvgScore(10);
        return $this->render('SerieBundle:Default:top10.html.twig',["series" => $series]);
    }

    public function detailAction($id)
    {
        $serie = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->getFullDetail($id);

        $comments = $this
            ->getDoctrine()
            ->getRepository("ToolBundle:Comment")
            ->getAllCommentBySerieId($id);

        $finalComments = [];
        foreach ($comments as $comment) {
            $result = [];
            $result[] = $comment[0];
            $result['nbLike'] = $comment['nbLike'];
            $result['nbDislike'] = $comment[0]->getNbDislikes($comment['nbLike']);
            $finalComments[] = $result;

        }
            // verifie si l'user a deja commenté la serie
            $commenter = $this
                ->getDoctrine()
                ->getRepository("ToolBundle:Comment")
                ->VerifyUserCanComment($this->getUser()->getId(),$serie[0]->getId());

        $commenter == null ? $commenter = false : $commenter = true;

        $comment = new Comment();
        $form = $this->createForm(new CommentType() ,$comment);

        return $this->render('SerieBundle:Default:detail.html.twig',
            [
                "serie" => $serie,
                "comments" => $finalComments,
                "commenter" => $commenter,
                'form' => $form->createView(),
            ]);
    }

    public function addAction(Request $request)
    {
        $serie = new Serie();
        $form = $this->createForm(new SerieType() ,$serie);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() )
        {
            $file = $serie->getPoster()->getPath();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where poster are stored
            $posterDir = $this->container->getParameter('kernel.root_dir').'/../web/images/series';
            $file->move($posterDir, $fileName);

            // Update the 'brochure' property to store the file name
            // instead of its contents
            $serie->getPoster()->setPath($fileName);

            // ... persist the $serie variable or any other work

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
            ->getXSeriesByAvgScore(30, 0);

        return $this->render('SerieBundle:Default:list.html.twig', array(
            'series' => $series,
        ));
    }

    public function listActorsAction()
    {
        $actors = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Actor")
            ->getAllActorsByLastname(30, 0);

        return $this->render('SerieBundle:Default:listActors.html.twig', array(
            'actors' => $actors,
        ));
    }

    public function listCategoryAction($id) {

        $doctrine = $this->getDoctrine();
        $category = $doctrine->getRepository('SerieBundle:Category')->find($id);

        $series = $doctrine
            ->getRepository("SerieBundle:Serie")
            ->getXSeriesByCategory($id);

        return $this->render('SerieBundle:Default:listByCategory.html.twig', array(
            'series' => $series,
            'category' => $category
        ));
    }

    public function searchAction(Request $req, $lkMethod, $lkValue)
    {
        $searchValue = $lkValue ? $lkValue : $req->request->get('search');
        // cheack if searchValue isn't empty
        if(!$searchValue) {
            $this->redirectToRoute('serie_homepage');
        }

        // find all serie which match searchValue
        $series = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Serie")
            ->getBySearchValue($searchValue);
        // find all actors which match searchValue
        $actors = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Actor")
            ->getBySearchValue($searchValue);
        // find all user which match searchValue
        $users = $this
            ->getDoctrine()
            ->getRepository("UserBundle:User")
            ->getBySearchValue($searchValue);

        if ($lkMethod === 'series' && ($series)) {
            $methodName = 'renderSerieSearch';
        } elseif ($lkMethod === 'actors' && count($actors)) {
            $methodName = 'renderActorSearch';
        } elseif ($lkMethod === 'users') {
            $methodName = 'renderUserSearch';
        } else {
            $methodName = 'renderSerieSearch';
        }

        return $this->forward('SerieBundle:Default:'. $methodName,
            array(
                'value' => $searchValue,
                'series' => $series,
                'actors' => $actors,
                'users' => $users,
            ));
    }

    public function renderSerieSearchAction($value, $series, $actors, $users) {

        return $this->render('SerieBundle:Default:searchResultSerie.html.twig',
            array(
                'value' => $value,
                'series' => $series,
                'nbActors' => count($actors),
                'nbUsers' => count($users),
            ));
    }

    public function renderActorSearchAction($value, $series, $actors, $users) {

        return $this->render('SerieBundle:Default:searchResultActor.html.twig',
            array(
                'value' => $value,
                'nbSeries' => count($series),
                'actors' => $actors,
                'nbUsers' => count($users),
            ));
    }

    public function renderUserSearchAction($value, $series, $actors, $users) {

        return $this->render('SerieBundle:Default:searchResultUser.html.twig',
            array(
                'value' => $value,
                'nbSeries' => count($series),
                'nbActors' => count($actors),
                'users' => $users,
            ));
    }

    public function detailEpisodeAction($idEpisode, $idSerie) {

        $episode = $this
            ->getDoctrine()
            ->getRepository("SerieBundle:Episode")
            ->find($idEpisode);

        return $this->render('SerieBundle:Default:detailEpisode.html.twig',
            array(
                'episode' => $episode
            ));
    }

}
