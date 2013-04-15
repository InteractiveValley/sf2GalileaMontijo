<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Richpolis\GalMonBundle\Entity\CategoriasGaleria;
use Richpolis\GalMonBundle\Entity\Galerias;
use Richpolis\GalMonBundle\Utils\qqFileUploader;
use Symfony\Component\HttpFoundation\Response;
use Richpolis\GalMonBundle\Entity\Fans;

class DefaultController extends Controller {

    public function getValoresSession($key, $default) {
        return $this->get('session')->get($key, $default);
    }

    public function setValoresSession($key, $value) {
        $this->get('session')->set($key, $value);
    }

    /**
     * @Route("/", name="RichpolisGalMonBundle_homepage")
     * @Template()
     */
    public function indexAction() {
        $publicidades = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:Publicidad')
                ->getPublicidadActuales();

        $categorias = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriasActuales();
        
        return array(
            'publicidades' => $publicidades,
            'categorias' => $categorias,
        );
    }

    /**
     * @Route("/video-semana", name="video_semana")
     * @Template()
     */
    public function videoSemanaAction() {
        $id = $this->getValoresSession('video', 0);
        $video = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:Videos')
                ->getVideoSemana($id);
        
        if(!$id && $video){
            $this->setValoresSession('video', $video->getId());
        }
        
        return array(
            'video' => $video->getVideo(),
        );
    }

    /**
     * @Route("/lo-que-estoy-viendo")
     * @Template()
     */
    public function loQueEstoyViendoAction() {
        $categoria = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$LO_QUE_ESTOY_VIENDO);
                
        if(!$categoria){
            $galerias=array();
        }else{
            $galerias=$categoria->getGalerias();
            $this->setValoresSession('lo-que-estoy-viendo', $categoria->getId());
        }

        return array(
            'categoria' => $categoria,
            'galerias' => $galerias,
        );
    }

    /**
     * @Route("/decora-tu-pantalla")
     * @Template()
     */
    public function decoraTuPantallaAction() {
        $categoria = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$DECORA_TU_PANTALLA);
        
        if(!$categoria){
            $galerias=array();
        }else{
            $galerias=$categoria->getGalerias();
            $this->setValoresSession('decora-tu-pantalla', $categoria->getId());
        }

        return array(
            'categoria' => $categoria,
            'galerias' => $galerias,
        );
    }

    /**
     * @Route("/galeria-oficial")
     * @Template()
     */
    public function galeriaOficialAction() {
        $categoria = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$GALERIA_OFICIAL);
        
        if(!$categoria){
            $galerias=array();
        }else{
            $galerias=$categoria->getGalerias();
            $this->setValoresSession('galeria-oficial', $categoria->getId());
        }

        return array(
            'categoria' => $categoria,
            'galerias' => $galerias,
        );
    }

    /**
     * @Route("/tus-fotos")
     * @Template()
     */
    public function tusFotosAction() {
        $categoria = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$TUS_FOTOS);
        
        if(!$categoria){
            $galerias=array();
        }else{
            $this->setValoresSession('tus-fotos', $categoria->getId());
            $galerias=$categoria->getGalerias();
        }

        return array(
            'categoria' => $categoria,
            'galerias' => $galerias,
        );
    }
    
    /**
     * @Route("/votaciones-semana")
     * @Template()
     */
    public function votacionesAction() {
        $semana = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                        ->getSemanaActual();
        
        $imagen_semana = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                        ->getImagenSemanaAnterior();
        
        $votaciones = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                        ->getVotacionesAleatorias($semana);

        return array(
            'semana' => $semana,
            'votaciones' => $votaciones,
            'imagen_semana' => $imagen_semana,
        );
    }

    /**
     * @Route("/trayectoria", name="RichpolisGalMonBundle_trayectoria")
     * @Template()
     */
    public function trayectoriaAction() {
        return array();
    }

    /**
     * @Route("/contacto", name="RichpolisGalMonBundle_contacto")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function contactoAction() {
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                        ->setSubject('Contacto desde pagina')
                        ->setFrom($contacto->getEmail())
                        ->setTo($this->container->getParameter('richpolis_galmon.emails.to_email'))
                        ->setBody($this->renderView('RichpoolisGalMonBundle:Default:contactoEmail.txt.twig', array('contacto' => $contacto)));
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('noticia', 'Gracias por enviar su correo!');

                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                return $this->redirect($this->generateUrl('RichpolisGalMonBundle_contacto'));
            }
        }

        return $this->render('RichpolisGalMonBundle:Default:contacto.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    

}
