<?php

namespace Chronogramm\TimelineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Chronogramm\TimelineBundle\Repository\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=1)
     */
    private $genre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="datetimetz")
     */
    private $dateNaissance;

    /**
     * @ORM\ManyToOne(targetEntity="Chronogramm\TimelineBundle\Entity\Event")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToMany(targetEntity="Chronogramm\TimelineBundle\Entity\Interest", cascade={"persist"})
     */
    private $interest;

    /**
     * @ORM\ManyToMany(targetEntity="Chronogramm\TimelineBundle\Entity\Badge", cascade={"persist"})
     */
    private $badge;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return User
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return User
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interest = new \Doctrine\Common\Collections\ArrayCollection();
        $this->badge = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set event
     *
     * @param \Chronogramm\TimelineBundle\Entity\Event $event
     *
     * @return User
     */
    public function setEvent(\Chronogramm\TimelineBundle\Entity\Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Chronogramm\TimelineBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Add interest
     *
     * @param \Chronogramm\TimelineBundle\Entity\Interest $interest
     *
     * @return User
     */
    public function addInterest(\Chronogramm\TimelineBundle\Entity\Interest $interest)
    {
        $this->interest[] = $interest;

        return $this;
    }

    /**
     * Remove interest
     *
     * @param \Chronogramm\TimelineBundle\Entity\Interest $interest
     */
    public function removeInterest(\Chronogramm\TimelineBundle\Entity\Interest $interest)
    {
        $this->interest->removeElement($interest);
    }

    /**
     * Get interest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Add badge
     *
     * @param \Chronogramm\TimelineBundle\Entity\Badge $badge
     *
     * @return User
     */
    public function addBadge(\Chronogramm\TimelineBundle\Entity\Badge $badge)
    {
        $this->badge[] = $badge;

        return $this;
    }

    /**
     * Remove badge
     *
     * @param \Chronogramm\TimelineBundle\Entity\Badge $badge
     */
    public function removeBadge(\Chronogramm\TimelineBundle\Entity\Badge $badge)
    {
        $this->badge->removeElement($badge);
    }

    /**
     * Get badge
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBadge()
    {
        return $this->badge;
    }
}
