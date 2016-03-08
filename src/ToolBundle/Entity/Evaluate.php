<?php

namespace ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="Serie")
     * @JoinColumn(name="serie_id", referencedColumnName="id")
     */
    private $serie;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
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
}
