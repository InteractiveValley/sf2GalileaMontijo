<?php

namespace Richpolis\GalMonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicaciones
 *
 * @ORM\Table(name="publicaciones")
 * @ORM\Entity(repositoryClass="Richpolis\GalMonBundle\Repository\PublicacionesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Publicaciones
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
     * @ORM\Column(name="publicacion", type="text", nullable=false)
     */
    private $publicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="link_video", type="string", length=255, nullable=true)
     */
    private $linkVideo;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", nullable=false)
     */
    private $posicion;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_publicacion", type="integer", nullable=false)
     */
    private $tipoPublicacion;

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

    static public $NOTICIAS=1;
    static public $TRAYECTORIA=2;
    static public $CONFIGURACION=3;
    
    static private $sCategorias=array(
        1=>'Noticias',
        2=>'Trayectoria',
        3=>'Configuracion'
    );
    
    
    public function __construct() {
       $this->isActive        =   true;
       $this->tipoCategoria   =   self::$NOTICIAS;
    }
    
    public function __toString() {
        return $this->getTitulo();
    }
    
    public function getStringTipoPublicacion(){
        return self::$sCategorias[$this->getTipoPublicacion()];
    }
    
    static function getArrayTipoPublicaciones(){
        return self::$sCategorias;
    }

    static function getPreferedTipoPublicacion(){
        return array(self::$NOTICIAS);
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
     * Set titulo
     *
     * @param string $titulo
     * @return Publicaciones
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
     * Set publicacion
     *
     * @param string $publicacion
     * @return Publicaciones
     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;
    
        return $this;
    }

    /**
     * Get publicacion
     *
     * @return string 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Publicaciones
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
     * Set linkVideo
     *
     * @param string $linkVideo
     * @return Publicaciones
     */
    public function setLinkVideo($linkVideo)
    {
        $this->linkVideo = $linkVideo;
    
        return $this;
    }

    /**
     * Get linkVideo
     *
     * @return string 
     */
    public function getLinkVideo()
    {
        return $this->linkVideo;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Publicaciones
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
     * Set tipoPublicacion
     *
     * @param integer $tipoPublicacion
     * @return Publicaciones
     */
    public function setTipoPublicacion($tipoPublicacion)
    {
        $this->tipoPublicacion = $tipoPublicacion;
    
        return $this;
    }

    /**
     * Get tipoPublicacion
     *
     * @return integer 
     */
    public function getTipoPublicacion()
    {
        return $this->tipoPublicacion;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Publicaciones
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
     * @return Publicaciones
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
     * @return Publicaciones
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
        $this->imagen = uniqid().'.'.$this->file->guessExtension();
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
        return '/uploads/publicaciones';
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

    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }
    
    public function getTipoArchivo(){
        $archivo=explode(".", $this->getImagen());
        $resp=1;
        switch ($archivo[1]){
            case "png":
            case "jpg":
            case "gif":
            case "jpeg":    
              $resp="Imagen";
              break;
            case "flv":
            case "mpg":
            case "mp4":
            case "avi":    
              $resp="Video";
              break;
            default:    
              $resp="Link";
              break;
        }
        return $resp;
    }
    public function getArchivoView(array $opciones){
        $respuesta="";
        $tipoarchivo=$this->getTipoArchivo();
        $archivo=$this->getImagen();
        
        
        switch($tipoarchivo){
            case "Imagen":
                $respuesta='<img src="'.$this->getWebPath().'" style="max-width:600px;max-height:400px;" title="'.$this->getTitulo().'"/>';
                break;
            case "Link":
                $video_link=$archivo;
                $wVideo=(!isset($opciones["width"])?560:$opciones["width"]);
                $hVideo=(!isset($opciones["height"])?400:$opciones["height"]);
                $withLayout=0;
                if(preg_match('/youtube\.com\/watch/i',$video_link)){
                    $respuesta='<iframe src ="http://www.youtube.com/embed/'.sfRichSys::getVideoIdYoutube($video_link).'?rel=1&autoplay=0" width="'.$wVideo.'" height="'.$hVideo.'" frameborder="no"></iframe>';
                }elseif(preg_match('/vimeo\.com/i',$video_link)){
                    $regExp="/http:\/\/(www\.)?vimeo.com\/(\d+)/";
                    preg_match($regExp,$video_link,$matches);
                    $respuesta='<iframe src="http://player.vimeo.com/video/'. $matches[2].'?autoplay=0" width="'.$wVideo.'" height="'.$hVideo.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                }
                break;
             case $tipos['Video']:
                $respuesta= sprintf(<<<EOF
<script type="text/javascript" src="/js/flowplayer-3.2.9.min.js"></script>
<a href="/uploads/galeria/%s"
   style="display:block;width:520px;height:330px"  
   id="player_%s"> 
</a> 
<!-- this will install flowplayer inside previous A- tag. -->
<script>
    flowplayer("player_%s", "/swf/flowplayer-3.2.10.swf");
</script>
EOF
      ,
      $this->getArchivo(),
      $this->getId(),
      $this->getId()
                  
    );
                break;

            
            case 'Musica':
                $respuesta= sprintf(<<<EOF
<link href="/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery.jplayer.min.js"></script>
<script>
$(document).ready(function(){
 $("#jquery_jplayer_%s").jPlayer({
  ready: function () {
   $(this).jPlayer("setMedia", {
    mp3: "/uploads/galeria/%s",
    oga: "/uploads/galeria/sound.ogg"
   });
  },
  swfPath: "/swf",
  supplied: "mp3, oga"
 });
}); 
</script>
<div id="jquery_jplayer_%s" class="jp-jplayer"></div>
    <div id="jp_container_1" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-time-holder">
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>

						<ul class="jp-toggles">
							<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
							<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
						</ul>
					</div>
				</div>
				<div class="jp-title">
					<ul>
						<li>Cro Magnon Man</li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>

EOF
      ,
      $this->getId(),
      $this->getArchivo(),
      $this->getId()
                  
    );
                break;
            case 'Flash':
                $respuesta= '<object id="archivo_galeria_'.$this->getId().'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="600" height="400"><param name="wmode" value="true" /><param name="allowfullscreen" value="false" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://'.$_SERVER['HTTP_HOST'].'/uploads/galeria/'.$this->getArchivo().'" /><embed src="http://'.$_SERVER['HTTP_HOST'].'/uploads/galeria/'.$this->getArchivo().'" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="always" width="600" height="400" wmode="true"></embed></object>';
                break;
        }
        return $respuesta;
     }
    
    
}