<?php

namespace SerieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

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
        $this->seasons = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->viewers = new ArrayCollection();
        $this->scores = new ArrayCollection();
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
     * @ORM\OneToOne(targetEntity="ToolBundle\Entity\Image",cascade={"persist","remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * @Assert\File(mimeTypes={"image/jpeg","image/jpg","image/png"})
     */
    private $poster;

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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ToolBundle\Entity\Evaluate", mappedBy="serie")
     */
    private $scores;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="seriesSeen")
     */
    private $viewers;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="SerieBundle\Entity\Category")
     * @ORM\JoinTable(name="category_serie",
     *      joinColumns={@ORM\JoinColumn(name="serie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     */
    private $categories;


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
     * @param User $viewers
     * @return Serie
     */
    public function addViewer(User $viewers)
    {
        $this->viewers[] = $viewers;

        return $this;
    }

    /**
     * Remove viewers
     *
     * @param User $viewers
     */
    public function removeViewer(User $viewers)
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

    /**
     * Add scores
     *
     * @param \ToolBundle\Entity\Evaluate $scores
     * @return Serie
     */
    public function addScore(\ToolBundle\Entity\Evaluate $scores)
    {
        $this->scores[] = $scores;

        return $this;
    }

    /**
     * Remove scores
     *
     * @param \ToolBundle\Entity\Evaluate $scores
     */
    public function removeScore(\ToolBundle\Entity\Evaluate $scores)
    {
        $this->scores->removeElement($scores);
    }

    /**
     * Get scores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScores()
    {
        return $this->scores;
    }
}
