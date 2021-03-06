<?php

namespace Richpolis\GalMonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Richpolis\GalMonBundle\Repository\SemanaVotacionesRepository;

/**
 * SemanaVotaciones
 *
 * @ORM\Table(name="categorias_galeria_votaciones")
 * @ORM\Entity(repositoryClass="Richpolis\GalMonBundle\Repository\SemanaVotacionesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class SemanaVotaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="semana", type="date", nullable=true)
     */
    private $semana;

    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", length=255, nullable=true)
     */
    private $tema;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", nullable=false)
     */
    private $posicion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @ORM\OneToMany(targetEntity="SemanaVotaciones", mappedBy="semana")
     */
    protected $votaciones;
    
    public function __construct() {
        $this->isActive=true;
        $this->votaciones =new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set semana
     *
     * @param \DateTime $semana
     * @return SemanaVotaciones
     */
    public function setSemana($semana)
    {
        $this->semana = $semana;
    
        return $this;
    }

    /**
     * Get semana
     *
     * @return \DateTime 
     */
    public function getSemana()
    {
        return $this->semana;
    }

    /**
     * Set tema
     *
     * @param string $tema
     * @return SemanaVotaciones
     */
    public function setTema($tema)
    {
        $this->tema = $tema;
    
        return $this;
    }

    /**
     * Get tema
     *
     * @return string 
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return SemanaVotaciones
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;
    
        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return SemanaVotaciones
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SemanaVotaciones
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return SemanaVotaciones
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add votaciones
     *
     * @param \Richpolis\GalMonBundle\Entity\SemanaVotaciones $votaciones
     * @return SemanaVotaciones
     */
    public function addVotacione(\Richpolis\GalMonBundle\Entity\SemanaVotaciones $votaciones)
    {
        $this->votaciones[] = $votaciones;
    
        return $this;
    }

    /**
     * Remove votaciones
     *
     * @param \Richpolis\GalMonBundle\Entity\SemanaVotaciones $votaciones
     */
    public function removeVotacione(\Richpolis\GalMonBundle\Entity\SemanaVotaciones $votaciones)
    {
        $this->votaciones->removeElement($votaciones);
    }

    /**
     * Get votaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotaciones()
    {
        return $this->votaciones;
    }
    
    /*** timestable ***/
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /*public function getImagenSemanaAnterior()
    {
        //$repository= new \Richpolis\GalMonBundle\Repository\se;
        $imagen=SemanaVotacionesRepository::getImagenSemanaAnterior();
        return $imagen;
    }   
    
    public function getVotacionesAleatorias(){
        //$repository= new \Richpolis\GalMonBundle\Repository\SemanaVotacionesRepository();
        $imagenes=  SemanaVotacionesRepository::getVotacionesAleatorias($this);
        return $imagenes;
    }*/

}