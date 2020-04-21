<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SuiviRepository")
 */
class Suivi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="suivis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeSuivi", inversedBy="suivis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

    /**
     * @ORM\Column(type="json")
     */
    private $resultat = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $at;


    public function __construct()
    {
        $this->at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getTheme(): ?TypeSuivi
    {
        return $this->theme;
    }

    public function setTheme(?TypeSuivi $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getResultat(): ?array
    {
        return $this->resultat;
    }

    public function setResultat(array $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getAt(): ?\DateTimeInterface
    {
        return $this->at;
    }

    public function setAt(\DateTimeInterface $at): self
    {
        $this->at = $at;

        return $this;
    }


}
