<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\SemanaVotaciones;
use Richpolis\GalMonBundle\Form\SemanaVotacionesType;

/**
 * SemanaVotaciones controller.
 *
 * @Route("/backend/semana/votaciones")
 */
class SemanaVotacionesController extends Controller
{
    protected function getFilters()
    {
        $filters=$this->get('session')->get('filters', array());
        return $filters;
    }

    /**
     * Lists all SemanaVotaciones entities.
     *
     * @Route("/", name="semana_votaciones")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                       ->getQuerySemanasActivas(true);

        $filters = $this->getFilters();

        if(!isset($filters['semanas'])){
            $semana=$em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->getSemanaActual();
            $filters['semanas']=$semana->getId();
            $this->get('session')->set('filters',$filters);
        }else{
            $semana=$em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->getSemanaConGaleriaPorId($filters['semanas']);
        }
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            10
        );
            
        return array(
            'semana_actual' => $semana,
            'pagination' => $pagination,
        );
    }

    /**
     * Finds and displays a SemanaVotaciones entity.
     *
     * @Route("/{id}/show", name="semana_votaciones_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $semana_actual = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                               ->getSemanaActual();
            
        $semana = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                               ->find($id);
        
        if (!$semana_actual && !$semana) {
            throw $this->createNotFoundException('Unable to find SemanaVotaciones entity.');
        }

        $semanas = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                ->getSemanasExceptoSemanaActual($semana_actual->getId());

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'        => $semana,
            'semana_actual' => $semana_actual,
            'semanas'       => $semanas,
            'delete_form'   => $deleteForm->createView(),

        );
    }
    
    public function semanaActualAction()
    {
        $semana_actual=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')
                ->getSemanaActual();
        if(!$semana_actual)
            return $this->formard($this->generateUrl('semana_votaciones_show',array('id'=>$semana_actual->getId())));
        else
            return $this->redirect($this->generateUrl('semana_votaciones'));
    }

    /**
     * Displays a form to create a new SemanaVotaciones entity.
     *
     * @Route("/new", name="semana_votaciones_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SemanaVotaciones();
        $max=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->getMaxPosicion();
        
        if(!is_null($max)){
            $entity->setPosicion($max+1);
        }else{
            $entity->setPosicion(1);
        }

        $form   = $this->createForm(new SemanaVotacionesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SemanaVotaciones entity.
     *
     * @Route("/create", name="semana_votaciones_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:SemanaVotaciones:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SemanaVotaciones();
        $form = $this->createForm(new SemanaVotacionesType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $filters = $this->getFilters();

            $filters['semanas']=$entity->getId();
            $this->get('session')->set('filters',$filters);
            
            return $this->redirect($this->generateUrl('semana_votaciones_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SemanaVotaciones entity.
     *
     * @Route("/{id}/edit", name="semana_votaciones_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SemanaVotaciones entity.');
        }

        $editForm = $this->createForm(new SemanaVotacionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SemanaVotaciones entity.
     *
     * @Route("/{id}/update", name="semana_votaciones_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:SemanaVotaciones:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SemanaVotaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SemanaVotacionesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('semana_votaciones_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SemanaVotaciones entity.
     *
     * @Route("/{id}/delete", name="semana_votaciones_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SemanaVotaciones entity.');
            }
            
            foreach($entity->getVotaciones() as $galeria){
                $em->remove($galeria);
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('semana_votaciones'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Galeria de una semana segun el status del registro.
     *
     * @Route("/galeria/{semana}/{isActive}", name="semana_votaciones_galeria")
     * @Template()
     */
    public function galeriaAction($semana,$isActive){
        $em = $this->getDoctrine()->getEntityManager();
        $entities=$em->getRepository('RichpolisGalMonBundle:Votaciones')
                ->getVotacionesPorSemanaYStatus($semana,$isActive);
        
        return array(
            'entities'=>$entities,
            'gallery_status'=>$isActive
        );
    }
    
    /**
     * Ordenar registros.
     *
     * @Route("/ordenar", name="semana_votaciones_ordenar")
     */
    public function ordenarGaleriaAction()
    {
        $request=$this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $semana = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->find($request->request->get("semana"));
            $registro_order = $request->query->get('registro');
            $em=$this->getDoctrine()->getEntityManager();
            $result['ok']="ok";
            foreach($registro_order as $order=>$id)
            {
                $registro=  $this->getDoctrine()->getRepository('RichpolisGalMonBundle:Votaciones')->find($id);
                if($registro->getPosicion()!=($order+1)){
                    try{
                        $registro->setPosicion($order+1);
                        $em->flush();
                    }catch(Exception $e){
                        $result['ok']=$e->getMessage();
                    }    
                }
            }
            
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        else {
            return null;
        }
    }
}
