<?php

namespace ToolBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * LikeDislike
 *
 * @ORM\Table(name="like_dislike")
 * @ORM\Entity(repositoryClass="ToolBundle\Repository\LikeDislikeRepository")
 */
class LikeDislike
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="likeIt", type="boolean")
     */
    private $likeIt;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="likes")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     */
    private $comment;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set likeIt
     *
     * @param boolean $likeIt
     * @return LikeDislike
     */
    public function setLikeIt($likeIt)
    {
        $this->likeIt = $likeIt;

        return $this;
    }

    /**
     * Get likeIt
     *
     * @return boolean 
     */
    public function getLikeIt()
    {
        return $this->likeIt;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return LikeDislike
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set comment
     *
     * @param Comment $comment
     * @return LikeDislike
     */
    public function setComment(Comment $comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return Comment
     */
    public function getComment()
    {
        return $this->comment;
    }
}
