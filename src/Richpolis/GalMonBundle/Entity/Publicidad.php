<?php

namespace Richpolis\GalMonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicidad
 *
 * @ORM\Table(name="publicidad")
 * @ORM\Entity(repositoryClass="Richpolis\GalMonBundle\Repository\PublicidadRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Publicidad
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
     * @ORM\Column(name="archivo", type="string", length=255, nullable=true)
     */
    private $archivo;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", nullable=false)
     */
    private $posicion;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_publicidad", type="integer", nullable=false)
     */
    private $tipoPublicidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actived_at", type="datetime", nullable=false)
     */
    private $activedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inatived_at", type="datetime", nullable=false)
     */
    private $inativedAt;

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

    static public $NIVEL1=1;
    static public $NIVEL2=2;
    static public $NIVEL3=3;
    static public $NIVEL4=4;
    static public $NIVEL5=5;
    static public $NIVEL6=6;
    
    static private $sCategorias=array(
        1=>'Nivel 1 460x130',
        2=>'Nivel 2 460x260',
        3=>'Nivel 3 679x118',
        4=>'Nivel 4 313x118',
        5=>'Nivel 5 679x118',
        6=>'Nivel 6 313x118'
    );

    
    public function __construct() {
       $this->isActive         =   true;
       $this->tipoPublicidad   =   self::$NIVEL1;
       $this->activedAt        =   new  \DateTime();
       $this->inativedAt       =   new  \DateTime();
       
    }
    
    public function getStringTipoPublicidad(){
        return self::$sCategorias[$this->getTipoPublicidad()];
    }
    
    static function getArrayTipoPublicidad(){
        return self::$sCategorias;
    }

    static function getPreferedTipoPublicidad(){
        return array(self::$NIVEL1);
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
     * Set archivo
     *
     * @param string $archivo
     * @return Publicidad
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;
    
        return $this;
    }

    /**
     * Get archivo
     *
     * @return string 
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Publicidad
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Publicidad
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Publicidad
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
     * Set tipoPublicidad
     *
     * @param integer $tipoPublicidad
     * @return Publicidad
     */
    public function setTipoPublicidad($tipoPublicidad)
    {
        $this->tipoPublicidad = $tipoPublicidad;
    
        return $this;
    }

    /**
     * Get tipoPublicidad
     *
     * @return integer 
     */
    public function getTipoPublicidad()
    {
        return $this->tipoPublicidad;
    }

    /**
     * Set activedAt
     *
     * @param \DateTime $activedAt
     * @return Publicidad
     */
    public function setActivedAt($activedAt)
    {
        $this->activedAt = $activedAt;
    
        return $this;
    }

    /**
     * Get activedAt
     *
     * @return \DateTime 
     */
    public function getActivedAt()
    {
        return $this->activedAt;
    }

    /**
     * Set inativedAt
     *
     * @param \DateTime $inativedAt
     * @return Publicidad
     */
    public function setInativedAt($inativedAt)
    {
        $this->inativedAt = $inativedAt;
    
        return $this;
    }

    /**
     * Get inativedAt
     *
     * @return \DateTime 
     */
    public function getInativedAt()
    {
        return $this->inativedAt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Publicidad
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
     * @return Publicidad
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
     * @return Publicidad
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
    
    /*** uploads ***/
    
    public $file;
    
    /**
    ** @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preUpload()
    {
      if (null !== $this->file) {
        // do whatever you want to generate a unique name
        $this->archivo = uniqid().'.'.$this->file->guessExtension();
      }
    }

    /**
    * @ORM\PostPersist
    * @ORM\PostUpdate
    */
    public function upload()
    {
      if (null === $this->file) {
        return;
      }

      // if there is an error when moving the file, an exception will
      // be automatically thrown by move(). This will properly prevent
      // the entity from being persisted to the database on error
      $this->file->move($this->getUploadRootDir(), $this->file);

      
      unset($this->file);
    }

    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
      if ($file = $this->getAbsolutePath()) {
        unlink($file);
      }
    }
    
    
    protected function getUploadDir()
    {
        return '/uploads/publicidad';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    public function getWebPath()
    {
        return null === $this->archivo ? null : $this->getUploadDir().'/'.$this->archivo;
    }

    
}