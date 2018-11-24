<?php

namespace Album\Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Track
 *
 * @ORM\Table(name="track", uniqueConstraints={@ORM\UniqueConstraint(name="fk_id_album", columns={"fk_id_album"})})
 * @ORM\Entity
 */
class Track
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
     * @ORM\Column(name="titulo", type="string", length=250, nullable=false)
     */
    private $titulo;

    /**
     * @var \Album\Album\Entity\Album
     *
     * @ORM\ManyToOne(targetEntity="Album\Album\Entity\Album")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_id_album", referencedColumnName="id")
     * })
     */
    private $fkAlbum;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo.
     *
     * @param string $titulo
     *
     * @return Track
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo.
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set fkAlbum.
     *
     * @param \Album\Album\Entity\Album|null $fkAlbum
     *
     * @return Track
     */
    public function setFkAlbum(\Album\Album\Entity\Album $fkAlbum = null)
    {
        $this->fkAlbum = $fkAlbum;

        return $this;
    }

    /**
     * Get fkAlbum.
     *
     * @return \Album\Album\Entity\Album|null
     */
    public function getFkAlbum()
    {
        return $this->fkAlbum;
    }
}
