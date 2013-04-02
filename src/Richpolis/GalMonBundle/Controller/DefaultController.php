<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Richpolis\GalMonBundle\Entity\CategoriasGaleria;

class DefaultController extends Controller
{
    public function getValoresSession($key,$default){
        return $this->get('session')->get($key,$default);
    }
    
    public function setValoresSession($key,$value){
        $this->get('session')->set($key,$value);
    }
    
    /**
     * @Route("/", name="RichpolisGalMonBundle_homepage")
     * @Template()
     */
    public function indexAction()
    {
        $publicidades=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:Publicidad')
                                        ->getPublicidadActuales();
        
        
        
        return array(
            'publicidades'=>$publicidades,
        );
    }
    
    /**
     * @Route("/video-semana", name="video_semana")
     * @Template()
     */
    public function videoSemanaAction()
    {
        $id=$this->getValoresSession('video', 0);
        $video=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:Videos')
                                    ->getVideoSemana($id);
        if(!$id){
            $this->setValoresSession('video', $video->getId());
        }
        
        return array(
            'video'=>$video->getVideo(),
        );
        
    }
    
    /**
     * @Route("/lo-que-estoy-viendo")
     * @Template()
     */
    public function loQueEstoyViendoAction()
    {
        $IdGaleria=$this->getValoresSession('lo-que-estoy-viendo', 0);
        $categoria=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                                    ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$LO_QUE_ESTOY_VIENDO);
        if(!$IdGaleria){
            $this->setValoresSession('lo-que-estoy-viendo', $categoria->getId());
        }
        
        return array(
            'categoria'=>$categoria,
            'galerias'=>$categoria->getGalerias(),
        );
        
    }
    
    /**
     * @Route("/decora-tu-pantalla")
     * @Template()
     */
    public function decoraTuPantallaAction()
    {
        $IdGaleria=$this->getValoresSession('decora-tu-pantalla', 0);
        $categoria=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                                    ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$DECORA_TU_PANTALLA);
        if(!$IdGaleria){
            $this->setValoresSession('decora-tu-pantalla', $categoria->getId());
        }
        
        return array(
            'categoria'=>$categoria,
            'galerias'=>$categoria->getGalerias(),
        );
        
    }
    
    /**
     * @Route("/galeria-oficial")
     * @Template()
     */
    public function galeriaOficialAction()
    {
        $IdGaleria=$this->getValoresSession('galeria-oficial', 0);
        $categoria=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                                    ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$GALERIA_OFICIAL);
        if(!$IdGaleria){
            $this->setValoresSession('galeria-oficial', $categoria->getId());
        }
        
        return array(
            'categoria'=>$categoria,
            'galerias'=>$categoria->getGalerias(),
        );
        
    }
    
    /**
     * @Route("/tus-fotos")
     * @Template()
     */
    public function tusFotosAction()
    {
        $IdGaleria=$this->getValoresSession('tus-fotos', 0);
        $categoria=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                                    ->getCategoriaActualPorTipoCategoria(CategoriasGaleria::$TUS_FOTOS);
        if(!$IdGaleria){
            $this->setValoresSession('tus-fotos', $categoria->getId());
        }
        
        return array(
            'categoria'=>$categoria,
            'galerias'=>$categoria->getGalerias(),
        );
        
    }
    
    /**
     * @Route("/trayectoria", name="RichpolisGalMonBundle_trayectoria")
     * @Template()
     */
    public function trayectoriaAction()
    {
        return array();
    }
    
    /**
     * @Route("/contacto", name="RichpolisGalMonBundle_contacto")
     * @Method({"GET", "POST"})
     * @Template()
     */
    
    public function contactoAction()
    {
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
