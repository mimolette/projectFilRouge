<?php

namespace SerieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Serie
 *
 * @ORM\Table(name="serie")
 * @ORM\Entity(repositoryClass="SerieBundle\Repository\SerieRepository")
 */
class Serie
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seasons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->viewers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=255, nullable=true)
     */
    private $poster = 'http://www.pilote-virtuel.com/img/facebook/0.jpg';

    /**
     * @var bool
     *
     * @ORM\Column(name="validation", type="boolean")
     */
    private $validation = false;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="text")
     */
    private $synopsis;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Season", mappedBy="serie", cascade={"persist", "remove"})
     *
     */
    private $seasons;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ToolBundle\Entity\Comment", mappedBy="serie")
     *
     */
    private $comments;


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
     * Set poster
     *
     * @param string $poster
     * @return Serie
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string 
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set validation
     *
     * @param boolean $validation
     * @return Serie
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
     * Set name
     *
     * @param string $name
     * @return Serie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set synopsis
     *
     * @param string $synopsis
     * @return Serie
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }


    /**
     * Add seasons
     *
     * @param \SerieBundle\Entity\Season $seasons
     * @return Serie
     */
    public function addSeason(\SerieBundle\Entity\Season $seasons)
    {
        $this->seasons[] = $seasons;

        return $this;
    }

    /**
     * Remove seasons
     *
     * @param \SerieBundle\Entity\Season $seasons
     */
    public function removeSeason(\SerieBundle\Entity\Season $seasons)
    {
        $this->seasons->removeElement($seasons);
    }

    /**
     * Get seasons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeasons()
    {
        return $this->seasons;
    }

    /**
     * Add categories
     *
     * @param \SerieBundle\Entity\Category $categories
     * @return Serie
     */
    public function addCategory(\SerieBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \SerieBundle\Entity\Category $categories
     */
    public function removeCategory(\SerieBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add comments
     *
     * @param \ToolBundle\Entity\Comment $comments
     * @return Serie
     */
    public function addComment(\ToolBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \ToolBundle\Entity\Comment $comments
     */
    public function removeComment(\ToolBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add actors
     *
     * @param \SerieBundle\Entity\Actor $actors
     * @return Serie
     */
    public function addActor(\SerieBundle\Entity\Actor $actors)
    {
        $this->actors[] = $actors;

        return $this;
    }

    /**
     * Remove actors
     *
     * @param \SerieBundle\Entity\Actor $actors
     */
    public function removeActor(\SerieBundle\Entity\Actor $actors)
    {
        $this->actors->removeElement($actors);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Add viewers
     *
     * @param \AppBundle\Entity\User $viewers
     * @return Serie
     */
    public function addViewer(\AppBundle\Entity\User $viewers)
    {
        $this->viewers[] = $viewers;

        return $this;
    }

    /**
     * Remove viewers
     *
     * @param \AppBundle\Entity\User $viewers
     */
    public function removeViewer(\AppBundle\Entity\User $viewers)
    {
        $this->viewers->removeElement($viewers);
    }

    /**
     * Get viewers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getViewers()
    {
        return $this->viewers;
    }
}
