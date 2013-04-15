<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Richpolis\GalMonBundle\Entity\Galerias;
use Richpolis\GalMonBundle\Entity\Fans;
use Richpolis\GalMonBundle\Entity\Votaciones;

class AmigosController extends Controller
{
    /**
     * @Route("/amigos", name="RichpolisGalMonBundle_amigos")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/amigos/{page}", name="RichpolisGalMonBundle_amigos_pagina")
     * @Template("RichpolisGalMonBundle:Amigos:index.html.twig")
     */
    public function paginaAction($page)
    {
        return array();
    }
    
    /**
     * @Route("/categoria/galeria/{categoria_id}", name="fans_categoria_galeria")
     * @Template()
     */
    public function categoriaGaleriaAction($categoria_id) {
        $categoria = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriaConGaleriaPorId($categoria_id);

        $formUpload = $this->createUploadForm($categoria->getId());

        return array(
            'galerias' => $categoria->getGalerias(),
            'categoria'=>$categoria,
            'formUpload' => $formUpload->createView(),
        );
    }
    
    /**
     * @Route("/semana/votaciones/{semana_id}", name="fans_semana_votaciones")
     * @Template()
     */
    public function semanaVotacionesAction($semana_id) {
        $semana = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                ->find($semana_id);
        
        $votaciones= $this->getDoctrine()->getRepository('RichpolisGalMonBundle:Votaciones')
                                         ->getVotacionesPorSemana($semana);

        
        return array(
            'votaciones' => $votaciones,
            'semana'=>  $semana,
        );
    }
    
    /**
     * @Route("/semana/voto/{votacion_id}", name="fans_semana_voto")
     */
    public function semanaVotoAction($votacion_id) {
        $votacion = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:Votaciones')
                ->find($votacion_id);

        $em=$this->getDoctrine()->getEntityManager();
        $votacion->setVotacion($votacion->getVotacion()+1);
        $em->flush();
        
        // create a JSON-response with a 200 status code
        $response = new Response(json_encode(array(
            "ok"=>"ok",
            "votacion"=>($votacion->getVotacion()),
            )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
                
    }

    /**
     * upload registro a galeria.
     *
     * @Route("/upload/galerias/{categoria_id}", name="fans_upload_galerias")
     * @Template("RichpolisGalMonBundle:Amigos:uploadGaleria.html.twig")
     */
    public function uploadGaleriaAction($categoria_id) {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createUploadForm($categoria_id);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $result=array();
            
            $form->bindRequest($request);
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

            $fan = $em->getRepository('RichpolisGalMonBundle:Fans')->getFanEnabledUpload($data);

            if (!$fan) {
                if(isset($data['email']) && strlen($data['email'])>3){
                    $fan=new Fans();
                    $fan->setNombre($data['nombre'])
                        ->setTwitter($data['twitter'])
                        ->setFacebook($data['facebook'])
                        ->setIsMostrarDatos($data['isMostrarDatos'])
                        ->setEmail($data['email']);
                    $em->persist($fan);
                    $em->flush();
                }else{
                   $result['ok']='bad';
                }
            } 
            
            if (!$fan->getIsActive()) {
                $result['ok']='bad';
            } else {
                $this->get('session')->set('usuario',$fan->getId());
                
                $max = $em->getRepository('RichpolisGalMonBundle:Galerias')->getMaxPosicion();
                $categoria = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')->find($categoria_id);

                $registro = new Galerias();
                $registro->file=$data["file"];
                $registro->setTitulo($data['titulo']);
                $registro->setIsActive(false);
                $registro->setPosicion($max + 1);
                $registro->setCategoria($categoria);
                $registro->setFan($fan);
                
                $em->persist($registro);
                $em->flush();
                
                $result['ok']='ok';
                
            }
            // create a JSON-response with a 200 status code
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            return array(
                'formUpload'=>$form->createView(),
                'categoria_id'=>$categoria_id,
            );
        }
    }

    
    /**
     * upload registro a galeria.
     *
     * @Route("/upload/votaciones/{semana_id}", name="fans_upload_votaciones")
     * @Template("RichpolisGalMonBundle:Amigos:uploadVotaciones.html.twig")
     */
    public function uploadVotacionesAction($semana_id) {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createUploadForm($semana_id);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $result=array();
            
            $form->bindRequest($request);
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

            $fan = $em->getRepository('RichpolisGalMonBundle:Fans')->getFanEnabledUpload($data);

            if (!$fan) {
                if(isset($data['email']) && strlen($data['email'])>3){
                    $fan=new Fans();
                    $fan->setNombre($data['nombre'])
                        ->setTwitter($data['twitter'])
                        ->setFacebook($data['facebook'])
                        ->setIsMostrarDatos($data['isMostrarDatos'])
                        ->setEmail($data['email']);
                    $em->persist($fan);
                    $em->flush();
                }else{
                   $result['ok']='bad';
                }
            } 
            
            if (!$fan->getIsActive()) {
                $result['ok']='bad';
            } else {
                $this->get('session')->set('usuario',$fan->getId());
                
                $max = $em->getRepository('RichpolisGalMonBundle:Votaciones')->getMaxPosicion();
                $semana = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->find($semana_id);

                $registro = new Votaciones();
                $registro->setTitulo($data['titulo']);
                $registro->file=$data["file"];
                $registro->setIsActive(false);
                $registro->setVotacion(0);
                $registro->setPosicion($max + 1);
                $registro->setSemana($semana);
                $registro->setFan($fan);
                
                $em->persist($registro);
                $em->flush();
                
                $result['ok']='ok';
                
            }
            // create a JSON-response with a 200 status code
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            return array(
                'formUpload'=>$form->createView(),
                'semana_id'=>$semana_id,
            );
        }
    }

    private function createUploadForm($id) {
       return $this->createFormBuilder(array('id' => $id))
                   ->add('nombre','text',array('attr'=>array('placeholder'=>'Nombre'),))
                   ->add('twitter','text',array('attr'=>array('placeholder'=>'Twitter')))
                   ->add('facebook','text',array('attr'=>array('placeholder'=>'Facebook')))
                   ->add('email', 'email', array(
                            'required' => true,
                            'attr'=>array('placeholder'=>'Email *obligatorio')
                            ))
                   ->add('isMostrarDatos', 'checkbox', array(
                            'label' => 'Mostrar Datos?',
                            'value' => 1,
                        ))
                   ->add('isActive', 'hidden',array(
                            'attr'=>array('value'=>1)
                            ))
                   ->add('titulo','text')
                   ->add('file', 'file', array('label' => 'Archivo'))
                   ->getForm()
            ;
    }
     
    

}
