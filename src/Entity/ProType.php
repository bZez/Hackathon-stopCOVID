<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProTypeRepository")
 */
class ProType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pro", mappedBy="type")
     */
    private $pros;

    public function __construct()
    {
        $this->pros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $pro->setType($this);
        }

        return $this;
    }

    public function removePro(Pro $pro): self
    {
        if ($this->pros->contains($pro)) {
            $this->pros->removeElement($pro);
            // set the owning side to null (unless already changed)
            if ($pro->getType() === $this) {
                $pro->setType(null);
            }
        }

        return $this;
    }
}
