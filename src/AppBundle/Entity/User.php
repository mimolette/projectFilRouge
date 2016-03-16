<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use ToolBundle\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
   */
  protected $firstname;

  /**
   * @var string
   *
   * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
   */
  protected $lastname;

  /**
   * @var DateTime
   *
   * @ORM\Column(name="day_of_birth", type="date", nullable=true)
   */
  protected $dayOfBirth;

  /**
   * @var string
   *
   * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
   */
  protected $avatar;

  /**
   * @var ArrayCollection
   *
   * @ORM\OneToMany(targetEntity="ToolBundle\Entity\Comment", mappedBy="user")
   */
  private $comments;

  /**
   * @var ArrayCollection
   *
   * @ORM\ManyToMany(targetEntity="SerieBundle\Entity\Serie")
   * @ORM\JoinTable(name="follow",
   *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="serie_id", referencedColumnName="id")}
   *      )
   */
  private $seriesFollowed;

  /**
   * @var ArrayCollection
   *
   * @ORM\ManyToMany(targetEntity="SerieBundle\Entity\Serie", inversedBy="viewers")
   * @ORM\JoinTable(name="see")
   */
  private $seriesSeen;

  public function __construct()
  {
    parent::__construct();
    $this->comments = new ArrayCollection();
    $this->seriesFollowed = new ArrayCollection();
    $this->seriesSeen = new ArrayCollection();
  }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set dayOfBirth
     *
     * @param \DateTime $dayOfBirth
     * @return User
     */
    public function setDayOfBirth($dayOfBirth)
    {
        $this->dayOfBirth = $dayOfBirth;

        return $this;
    }

    /**
     * Get dayOfBirth
     *
     * @return \DateTime 
     */
    public function getDayOfBirth()
    {
        return $this->dayOfBirth;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add comments
     *
     * @param Comment $comments
     * @return User
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
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
     * Add seriesFollowed
     *
     * @param \SerieBundle\Entity\Serie $seriesFollowed
     * @return User
     */
    public function addSeriesFollowed(\SerieBundle\Entity\Serie $seriesFollowed)
    {
        $this->seriesFollowed[] = $seriesFollowed;

        return $this;
    }

    /**
     * Remove seriesFollowed
     *
     * @param \SerieBundle\Entity\Serie $seriesFollowed
     */
    public function removeSeriesFollowed(\SerieBundle\Entity\Serie $seriesFollowed)
    {
        $this->seriesFollowed->removeElement($seriesFollowed);
    }

    /**
     * Get seriesFollowed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeriesFollowed()
    {
        return $this->seriesFollowed;
    }

    /**
     * Add seriesSeen
     *
     * @param \SerieBundle\Entity\Serie $seriesSeen
     * @return User
     */
    public function addSeriesSeen(\SerieBundle\Entity\Serie $seriesSeen)
    {
        $this->seriesSeen[] = $seriesSeen;

        return $this;
    }

    /**
     * Remove seriesSeen
     *
     * @param \SerieBundle\Entity\Serie $seriesSeen
     */
    public function removeSeriesSeen(\SerieBundle\Entity\Serie $seriesSeen)
    {
        $this->seriesSeen->removeElement($seriesSeen);
    }

    /**
     * Get seriesSeen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeriesSeen()
    {
        return $this->seriesSeen;
    }
}
