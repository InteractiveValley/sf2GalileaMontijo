<?php

namespace Richpolis\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="RichpolisBackendBundle_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/navegar", name="RichpolisBackendBundle_navegar")
     * @Template()
     */
    public function navegarAction()
    {
        return array();
    }
    
    /**
     * @Route("/seleccionar/galeria", name="RichpolisBackendBundle_categorias_galerias")
     */
    public function categoriasAction()
    {
        return $this->forward('RichpolisGalMonBundle:CategoriasGaleria:select');
    }
    
    /**
     * @Route("/galeria/lo-que-estoy-viendo", name="RichpolisBackendBundle_galeria_loqueestoyviendo")
     */
    public function galeriaLoQueEstoyViendoAction()
    {
        return $this->forward('RichpolisGalMonBundle:CategoriasGaleria:loQueEstoyViendo');
    }
    
    /**
     * @Route("/galeria/oficial", name="RichpolisBackendBundle_galeria_oficial")
     */
    public function galeriaOficialAction()
    {
        return $this->forward('RichpolisGalMonBundle:CategoriasGaleria:oficial');
    }
    
    /**
     * @Route("/galeria/tus-fotos", name="RichpolisBackendBundle_galeria_tusfotos")
     */
    public function galeriaTusFotosAction()
    {
        return $this->forward('RichpolisGalMonBundle:CategoriasGaleria:tusFotos');
    }
    
    /**
     * @Route("/galeria/decora-tu-pantalla", name="RichpolisBackendBundle_galeria_decoratupantalla")
     */
    public function galeriaDecoraTuPantallaAction()
    {
        return $this->forward('RichpolisGalMonBundle:CategoriasGaleria:decoraTuPantalla');
    }
    
    /**
     * @Route("/semana/votaciones", name="RichpolisBackendBundle_semana_votaciones")
     */
    public function semanaVotacionesAction()
    {
        return $this->forward('RichpolisGalMonBundle:SemanaVotaciones:index');
    }
    
    /**
     * @Route("/semana/actual", name="RichpolisBackendBundle_semana_actual")
     */
    public function semanaActualAction()
    {
        return $this->forward('RichpolisGalMonBundle:SemanaVotaciones:semanaActual');
    }
    
    /**
     * @Route("/videos", name="RichpolisBackendBundle_videos")
     */
    public function videosAction()
    {
        return $this->forward('RichpolisGalMonBundle:Videos:index');
    }
    
    
    /**
     * @Route("/seleccionar/publicaciones", name="RichpolisBackendBundle_publicaciones")
     */
    public function publicacionesAction()
    {
        return $this->forward('RichpolisGalMonBundle:Publicaciones:select');
    }
    
    /**
     * @Route("/publicaciones/noticias", name="RichpolisBackendBundle_publicacion_noticias")
     */
    public function publicacionesNoticiasAction()
    {
        return $this->forward('RichpolisGalMonBundle:Publicaciones:noticias');
    }
    
    /**
     * @Route("/publicaciones/trayectoria", name="RichpolisBackendBundle_publicacion_trayectoria")
     */
    public function publicacionesTrayectoriaAction()
    {
        return $this->forward('RichpolisGalMonBundle:Publicaciones:trayectoria');
    }
    
    /**
     * @Route("/publicaciones/configuracion", name="RichpolisBackendBundle_publicacion_configuracion")
     */
    public function publicacionesConfiguracionAction()
    {
        return $this->forward('RichpolisGalMonBundle:Publicaciones:configuracion');
    }
    
    /**
     * @Route("/seleccionar/publicidad", name="RichpolisBackendBundle_publicidad")
     */
    public function publicidadAction()
    {
        return $this->forward('RichpolisGalMonBundle:Publicidad:select');
    }
    
    /**
     * @Route("/publicidad/{tipo_publicidad}/nivel/", name="RichpolisBackendBundle_nivel")
     */
    public function publicidadNivelAction($tipo_publicidad)
    {
        return $this->forward('RichpolisGalMonBundle:Publicidad:porTipo',
                array("tipo"=>$tipo_publicidad));
    }
    
    /**
     * @Route("/fans", name="RichpolisBackendBundle_fans")
     */
    public function fansAction()
    {
        return $this->forward('RichpolisGalMonBundle:Fans:index');
    }
    
    /**
     * @Route("/clubs/fans", name="RichpolisBackendBundle_clubs_fans")
     */
    public function clubsFansAction()
    {
        return $this->forward('RichpolisGalMonBundle:ClubsFans:index');
    }
    
    /**
     * @Route("/usuarios", name="RichpolisBackendBundle_usuarios")
     */
    public function usuariosAction()
    {
        return $this->forward('RichpolisGalMonBundle:Usuarios:index');
    }
    
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'RichpolisBackendBundle:Default:login.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
}
