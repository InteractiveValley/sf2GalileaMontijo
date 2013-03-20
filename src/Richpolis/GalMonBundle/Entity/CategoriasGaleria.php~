<?php

namespace Richpolis\GalMonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoriasGaleria
 *
 * @ORM\Table(name="categorias_galeria")
 * @ORM\Entity(repositoryClass="Richpolis\GalMonBundle\Repository\CategoriasGaleriaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CategoriasGaleria
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
     * @ORM\Column(name="categoria", type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_categoria", type="integer", nullable=false)
     */
    private $tipoCategoria;

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
     * @ORM\OneToMany(targetEntity="Galerias", mappedBy="categoria")
     */
    protected $galerias;
    
    static public $LO_QUE_ESTOY_VIENDO=1;
    static public $GALERIA_OFICIAL=2;
    static public $TUS_FOTOS=3;
    static public $DECORA_TU_PANTALLA=4;
    
    static private $sCategorias=array(
        1=>'Lo Que Estoy Viendo',
        2=>'Galeria Oficial',
        3=>'Tus Fotos',
        4=>'Decora tu pantalla'
    );
    
    public function __construct() {
        $this->isActive=true;
        $this->tipoCategoria=self::$LO_QUE_ESTOY_VIENDO;
        $this->galerias =new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getStringTipoCategoria(){
        return self::$sCategorias[$this->getTipoCategoria()];
    }

    static function getArrayTipoCategorias(){
        return self::$sCategorias;
    }

    static function getPreferedTipoCategoria(){
        return array(self::$GALERIA_OFICIAL);
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
     * Set categoria
     *
     * @param string $categoria
     * @return CategoriasGaleria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set tipoCategoria
     *
     * @param integer $tipoCategoria
     * @return CategoriasGaleria
     */
    public function setTipoCategoria($tipoCategoria)
    {
        $this->tipoCategoria = $tipoCategoria;
    
        return $this;
    }

    /**
     * Get tipoCategoria
     *
     * @return integer 
     */
    public function getTipoCategoria()
    {
        return $this->tipoCategoria;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return CategoriasGaleria
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
     * @return CategoriasGaleria
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
     * @return CategoriasGaleria
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
     * @return CategoriasGaleria
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
     * @return CategoriasGaleria
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
    
        
    
}