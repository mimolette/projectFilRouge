<?php

namespace ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="ToolBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var \DateTime
     *
     * @ORM\Column(name="postDate", type="datetime")
     */
    private $postDate;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="validation", type="boolean")
     */
    private $validation;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer", nullable=true)
     */
    private $rate;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User",inversedBy="comments")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetentity="Serie", inversedBy="comments")
     * @ORM\JoinColumn(name="serie_id", referencedColumnName="id")
     */
    private $serie;

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
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return Comment
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime 
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set validation
     *
     * @param boolean $validation
     * @return Comment
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return boolean 
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     * @return Comment
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }
}
