<?php

namespace Richpolis\GalMonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Richpolis\GalMonBundle\Entity\CategoriasGaleria;

/**
 * Galerias
 *
 * @ORM\Table(name="galerias")
 * @ORM\Entity(repositoryClass="Richpolis\GalMonBundle\Repository\GaleriasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Galerias
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
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

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
     * @var \CategoriasGaleria
     *
     * @ORM\ManyToOne(targetEntity="CategoriasGaleria", inversedBy="galerias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     * @var \Fans
     *
     * @ORM\ManyToOne(targetEntity="Fans", inversedBy="galerias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fan_id", referencedColumnName="id")
     * })
     */
    private $fan;



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
     * Set titulo
     *
     * @param string $titulo
     * @return Galerias
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Galerias
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    
        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Galerias
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
     * Set posicion
     *
     * @param integer $posicion
     * @return Galerias
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
     * @return Galerias
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
     * @return Galerias
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
     * @return Galerias
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
     * Set categoria
     *
     * @param \Richpolis\GalMonBundle\Entity\CategoriasGaleria $categoria
     * @return Galerias
     */
    public function setCategoria(\Richpolis\GalMonBundle\Entity\CategoriasGaleria $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Richpolis\GalMonBundle\Entity\CategoriasGaleria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set fan
     *
     * @param \Richpolis\GalMonBundle\Entity\Fans $fan
     * @return Galerias
     */
    public function setFan(\Richpolis\GalMonBundle\Entity\Fans $fan = null)
    {
        $this->fan = $fan;
    
        return $this;
    }

    /**
     * Get fan
     *
     * @return \Richpolis\GalMonBundle\Entity\Fans 
     */
    public function getFan()
    {
        return $this->fan;
    }
    
    /**
     * Regresa el titulo corto segun el maximo de caracteres solicitado
     * 
     * @return string
     * 
     */
    
    public function getTituloCorto($max=15){
        if($this->titulo)
            return substr($this->getTitulo(), 0, $max);
        else
            return "Sin titulo";
    }
   
    /*
     * Crea el thumbnail y lo guarda en un carpeta dentro del webPath thumbnails
     * 
     * @return void
     */
    private function crearThumbnail(){
        $imagine= new \Imagine\Gd\Imagine();
        $mode= \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
        $size=new \Imagine\Image\Box($this->getWidth(),$this->getHeight());
        $this->thumbnail=$this->imagen;
        
        $imagine->open($this->getAbsolutePath())
                ->thumbnail($size, $mode)
                ->save($this->getAbosluteThumbnailPath());
        
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
        $this->imagen       =   uniqid().'.'.$this->file->guessExtension();
        $this->thumbnail    =   $this->imagen;
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
      $this->file->move($this->getUploadRootDir(), $this->imagen);

      $this->crearThumbnail();
      
      unset($this->file);
    }

    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
      if ($file = $this->getAbsolutePath()) {
        if(file_exists($file)){
            unlink($file);
        }
      }
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
        }
      }
    }
    
    protected function getUploadDir()
    {
        return '/uploads/galerias';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    protected function getThumbnailRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir().'/thumbnails';
    }
        
    public function getWebPath()
    {
        return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }

    public function getThumbnailWebPath()
    {
        if(!$this->thumbnail){
            if(!file_exists($this->getAbosluteThumbnailPath()) && file_exists($this->getAbsolutePath())){
                $this->crearThumbnail();
            }
        }
        return null === $this->thumbnail ? null : $this->getUploadDir().'/thumbnails/'.$this->thumbnail;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }
    
    public function getAbosluteThumbnailPath(){
        return null === $this->thumbnail ? null : $this->getUploadRootDir().'/thumbnails/'.$this->thumbnail;
    }
    
    public function actualizaThumbnail()
    {
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
        }
      }
      $this->crearThumbnail();
    }
    
    public function getArchivoView(){
        $opciones=array(
            'tipo_archivo'  => Richsys::getTipoArchivo($this->getImagen()),
            'archivo'   =>  $this->getImagen(),
            'carpeta'   =>  'galerias',
            'width'     =>  $this->getWidth(),
            'height'    =>  $this->geHeight(),
        );
        
        return Richsys::getArchivoView($opciones);
    }
    public function getWidth(){
        switch($this->getCategoria()->getTipoCategoria()){
            case CategoriasGaleria::$LO_QUE_ESTOY_VIENDO: //84x91
                $resp= 84;
                break;
            case CategoriasGaleria::$DECORA_TU_PANTALLA: //460x306
                $resp=460;
                break;
            case CategoriasGaleria::$GALERIA_OFICIAL: // 145x175
            case CategoriasGaleria::$TUS_FOTOS: // 145x145
                $resp=145;
                break;
        }
        return $resp;
    }
    public function getHeight(){
        switch($this->getCategoria()->getTipoCategoria()){
            case CategoriasGaleria::$LO_QUE_ESTOY_VIENDO: //84x91
                $resp= 91;
                break;
            case CategoriasGaleria::$DECORA_TU_PANTALLA: //460x306
                $resp=306;
                break;
            case CategoriasGaleria::$GALERIA_OFICIAL: // 145x175
                $resp=175;
                break;
            case CategoriasGaleria::$TUS_FOTOS: // 145x145
                $resp=145;
                break;
        }
        return $resp;
    }
}