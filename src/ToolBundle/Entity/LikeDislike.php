<?php

namespace ToolBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Comment")
     * @JoinColumn(name="comment_id", referencedColumnName="id")
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
}
