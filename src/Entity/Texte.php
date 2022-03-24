<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Section;

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

    public function getIdsection()
    {
        return $this->idsection;
    }

    public function setIdsection(?Section $idsection): self
    {
        $this->idsection = $idsection;

        return $this;
    }


}
