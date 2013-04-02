<?php

namespace Richpolis\GalMonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fans
 *
 * @ORM\Table(name="fans")
 * @ORM\Entity(repositoryClass="Richpolis\GalMonBundle\Repository\FansRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Fans
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

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
     * @var boolean
     *
     * @ORM\Column(name="is_mostrar_datos", type="boolean", nullable=true)
     */
    private $isMostrarDatos;
    
    /**
     * @ORM\OneToMany(targetEntity="Galerias", mappedBy="fan")
     */
    protected $galerias;
    
    /**
     * @ORM\OneToMany(targetEntity="Votaciones", mappedBy="fan")
     */
    protected $votaciones;
    
    public function __construct() {
        $this->isActive=true;
        $this->galerias =new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Fans
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Fans
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    
        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Fans
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    
        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Fans
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Fans
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
     * @return Fans
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
     * @return Fans
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
     * Add galerias
     *
     * @param \Richpolis\GalMonBundle\Entity\Galerias $galerias
     * @return Fans
     */
    public function addGaleria(\Richpolis\GalMonBundle\Entity\Galerias $galerias)
    {
        $this->galerias[] = $galerias;
    
        return $this;
    }

    /**
     * Remove galerias
     *
     * @param \Richpolis\GalMonBundle\Entity\Galerias $galerias
     */
    public function removeGaleria(\Richpolis\GalMonBundle\Entity\Galerias $galerias)
    {
        $this->galerias->removeElement($galerias);
    }

    /**
     * Get galerias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalerias()
    {
        return $this->galerias;
    }

    /**
     * Add votaciones
     *
     * @param \Richpolis\GalMonBundle\Entity\Votaciones $votaciones
     * @return Fans
     */
    public function addVotacione(\Richpolis\GalMonBundle\Entity\Votaciones $votaciones)
    {
        $this->votaciones[] = $votaciones;
    
        return $this;
    }

    /**
     * Remove votaciones
     *
     * @param \Richpolis\GalMonBundle\Entity\Votaciones $votaciones
     */
    public function removeVotacione(\Richpolis\GalMonBundle\Entity\Votaciones $votaciones)
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
     * @ORM\PrePersist
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

    /**
     * Set isMostrarDatos
     *
     * @param boolean $isMostrarDatos
     * @return Fans
     */
    public function setIsMostrarDatos($isMostrarDatos)
    {
        $this->isMostrarDatos = $isMostrarDatos;
    
        return $this;
    }

    /**
     * Get isMostrarDatos
     *
     * @return boolean 
     */
    public function getIsMostrarDatos()
    {
        return $this->isMostrarDatos;
    }
}