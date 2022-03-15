<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Texte
 *
 * @ORM\Table(name="texte", indexes={@ORM\Index(name="FK_Texte_id_Section", columns={"idSection"})})
 * @ORM\Entity
 */
class Texte
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
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var int
     *
     * @ORM\Column(name="posX", type="integer", nullable=false)
     */
    private $posx;

    /**
     * @var int
     *
     * @ORM\Column(name="posY", type="integer", nullable=false)
     */
    private $posy;

    /**
     * @var int
     *
     * @ORM\Column(name="largeur", type="integer", nullable=false)
     */
    private $largeur;

    /**
     * @var int
     *
     * @ORM\Column(name="hauteur", type="integer", nullable=false)
     */
    private $hauteur;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSection", referencedColumnName="id")
     * })
     */
    private $idsection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPosx(): ?int
    {
        return $this->posx;
    }

    public function setPosx(int $posx): self
    {
        $this->posx = $posx;

        return $this;
    }

    public function getPosy(): ?int
    {
        return $this->posy;
    }

    public function setPosy(int $posy): self
    {
        $this->posy = $posy;

        return $this;
    }

    public function getLargeur(): ?int
    {
        return $this->largeur;
    }

    public function setLargeur(int $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?int
    {
        return $this->hauteur;
    }

    public function setHauteur(int $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getIdsection(): ?Section
    {
        return $this->idsection;
    }

    public function setIdsection(?Section $idsection): self
    {
        $this->idsection = $idsection;

        return $this;
    }


}
