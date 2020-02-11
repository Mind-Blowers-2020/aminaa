<?php

namespace gestioneventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="gestioneventBundle\Repository\participantRepository")
 */
class participant
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
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length = 255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length = 255)
     */
    private $prenom;

    /**
     * @ORM\ManyToOne(targetEntity="gestioneventBundle\Entity\Evenement")
     * @ORM\JoinColumn(name="evenement",referencedColumnName="id" ,onDelete="CASCADE")
     *
     */
    private $evenement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscrit", type="datetime")
     */
    private $dateInscrit;



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
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return Participants
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return bool
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }
    /**
     * Set evenement
     *
     * @param string $evenement
     *
     * @return Participants
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return string
     */
    public function getEvenement()
    {
        return $this->evenement;
    }
    /**
     * Set dateInscrit
     *
     * @param \DateTime $dateInscrit
     *
     * @return Participants
     */
    public function setDateInscrit($dateInscrit)
    {
        $this->dateInscrit = $dateInscrit;

        return $this;
    }

    /**
     * Get dateInscrit
     *
     * @return \DateTime
     */
    public function getDateInscrit()
    {
        return $this->dateInscrit;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }












}

