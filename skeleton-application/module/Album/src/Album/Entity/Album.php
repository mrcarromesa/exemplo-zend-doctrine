<?php

namespace Album\Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity
 */
class Album
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
     * @ORM\Column(name="artista", type="string", length=250, nullable=false)
     */
    private $artista;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=250, nullable=false)
     */
    private $titulo;



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
     * Set artista.
     *
     * @param string $artista
     *
     * @return Album
     */
    public function setArtista($artista)
    {
        $this->artista = $artista;

        return $this;
    }

    /**
     * Get artista.
     *
     * @return string
     */
    public function getArtista()
    {
        return $this->artista;
    }

    /**
     * Set titulo.
     *
     * @param string $titulo
     *
     * @return Album
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
}
