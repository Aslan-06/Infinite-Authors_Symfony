<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section", indexes={@ORM\Index(name="FK_Section_id_Livre", columns={"idLivre"})})
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
     * @ORM\Column(name="numSequence", type="integer", nullable=false, options={"default"="1"})
     */
    private $numsequence = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="niveau", type="integer", nullable=false)
     */
    private $niveau;

    /**
     * @var int
     *
     * @ORM\Column(name="idLivre", type="integer", nullable=false)
     */
    private $idlivre;

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

    public function getIdlivre(): ?int
    {
        return $this->idlivre;
    }

    public function setIdlivre(int $idlivre): self
    {
        $this->idlivre = $idlivre;

        return $this;
    }


}
