<?php

namespace ToolBundle\Entity;

use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use SerieBundle\Entity\Serie;

/**
 * Evaluate
 *
 * @ORM\Table(name="evaluate")
 * @ORM\Entity(repositoryClass="ToolBundle\Repository\EvaluateRepository")
 */
class Evaluate
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
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=false)
     */
    private $score;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="SerieBundle\Entity\Serie", inversedBy="scores")
     * @ORM\JoinColumn(name="serie_id", referencedColumnName="id")
     */
    private $serie;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set score
     *
     * @param float $score
     * @return Evaluate
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set serie
     *
     * @param Serie $serie
     * @return Evaluate
     */
    public function setSerie(Serie $serie = null)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Evaluate
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
}
