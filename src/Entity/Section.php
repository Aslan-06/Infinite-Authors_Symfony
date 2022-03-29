<?php

namespace App\Entity;

use App\Entity\Livre;
use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section", indexes={@ORM\Index(name="fk-constraint_livre", columns={"Livre"})})
 * @ORM\Entity
 */
class Section
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="numSequence", type="integer", nullable=false)
     */
    private $numsequence;

    /**
     * @var int
     *
     * @ORM\Column(name="niveau", type="integer", nullable=false, options={"default"="1"})
     */
    private $niveau = 1;

    /**
     * @var \Livre
     *
     * @ORM\ManyToOne(targetEntity="Livre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Livre", referencedColumnName="id")
     * })
     */
    private $livre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNumsequence(): ?int
    {
        return $this->numsequence;
    }

    public function setNumsequence(int $numsequence): self
    {
        $this->numsequence = $numsequence;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }


}
