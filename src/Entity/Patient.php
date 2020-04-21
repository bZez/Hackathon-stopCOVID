<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class Patient implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $insee;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Suivi", mappedBy="patient")
     */
    private $suivis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ordo", mappedBy="patient")
     */
    private $ordos;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $mutuelle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pro", mappedBy="patients")
     */
    private $pros;

    public function __construct()
    {
        $this->suivis = new ArrayCollection();
        $this->ordos = new ArrayCollection();
        $this->pros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    function __clone()
    {
        $this->id = null;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getInsee(): ?string
    {
        return $this->insee;
    }

    public function setInsee(string $insee): self
    {
        $this->insee = $insee;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Suivi[]
     */
    public function getSuivis(): Collection
    {
        return $this->suivis;
    }

    public function addSuivi(Suivi $suivi): self
    {
        if (!$this->suivis->contains($suivi)) {
            $this->suivis[] = $suivi;
            $suivi->setPatient($this);
        }

        return $this;
    }

    public function removeSuivi(Suivi $suivi): self
    {
        if ($this->suivis->contains($suivi)) {
            $this->suivis->removeElement($suivi);
            // set the owning side to null (unless already changed)
            if ($suivi->getPatient() === $this) {
                $suivi->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ordo[]
     */
    public function getOrdos(): Collection
    {
        return $this->ordos;
    }

    public function addOrdo(Ordo $ordo): self
    {
        if (!$this->ordos->contains($ordo)) {
            $this->ordos[] = $ordo;
            $ordo->setPatient($this);
        }

        return $this;
    }

    public function removeOrdo(Ordo $ordo): self
    {
        if ($this->ordos->contains($ordo)) {
            $this->ordos->removeElement($ordo);
            // set the owning side to null (unless already changed)
            if ($ordo->getPatient() === $this) {
                $ordo->setPatient(null);
            }
        }

        return $this;
    }

    public function getMutuelle(): ?string
    {
        return $this->mutuelle;
    }

    public function setMutuelle(string $mutuelle): self
    {
        $this->mutuelle = $mutuelle;

        return $this;
    }

    /**
     * @return Collection|Pro[]
     */
    public function getPros(): Collection
    {
        return $this->pros;
    }

    public function addPro(Pro $pro): self
    {
        if (!$this->pros->contains($pro)) {
            $this->pros[] = $pro;
            $pro->addPatient($this);
        }

        return $this;
    }

    public function removePro(Pro $pro): self
    {
        if ($this->pros->contains($pro)) {
            $this->pros->removeElement($pro);
            $pro->removePatient($this);
        }

        return $this;
    }
}
