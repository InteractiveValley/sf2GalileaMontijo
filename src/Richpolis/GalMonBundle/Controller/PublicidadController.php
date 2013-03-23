<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\Publicidad;
use Richpolis\GalMonBundle\Form\PublicidadType;


/**
 * Publicidad controller.
 *
 * @Route("/publicidad")
 */
class PublicidadController extends Controller
{
    protected function getFilters()
    {
        $filters=$this->get('session')->get('filters', array());
        return $filters;
    }

    /**
     * Lists all Publicidad entities.
     *
     * @Route("/", name="publicidad")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $filters = $this->getFilters();

        if(!isset($filters['publicidad']))
            $filters['publicidad']=Publicidad::$NIVEL1;

        $query = $em->getRepository('RichpolisGalMonBundle:Publicidad')
                            ->getQueryPublicidadPorTipoYActivas($filters['publicidad'],true);
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            10
        );

        return array(
            'tipos'             => Publicidad::getArrayTipoPublicidad(),
            'tipo_publicidad'   => $filters['publicidad'],
            'pagination' => $pagination,
        );
    }

    /**
     * Seleccionar un tipo de publicidad.
     *
     * @Route("/seleccionar", name="publicidad_seleccionar")
     */
    public function selectAction()
    {
        $filters = $this->getFilters();
        
        if(isset($filters['publicidad'])){
            return $this->redirect($this->generateUrl('publicidad'));
        }else{
            return $this->render('RichpolisGalMonBundle:Publicidad:select.html.twig', array(
                'tipos'  => Publicidad::getArrayTipoPublicidad(),
            ));
        }
    }

    /**
     * Mostrar publicaciones por tipo
     *
     * @Route("/list/{tipo}/tipo", name="publicidad_por_tipo")
     */
    public function porTipoAction($tipo)
    {
        $filters = $this->getFilters();
        if($tipo){
            $filters['publicidad']=$tipo;
            $this->get('session')->set('filters',$filters);
            return $this->redirect($this->generateUrl('publicidad'));   
        }else{
            if(isset($filters['publicidad'])){
                return $this->redirect($this->generateUrl('publicidad'));
            }else{
                return $this->render('RichpolisGalMonBundle:Publicidad:select.html.twig', array(
                    'tipos'  => Publicidad::getArrayTipoPublicidad(),
                ));
            }
        }
    }

    /**
     * Finds and displays a Publicidad entity.
     *
     * @Route("/{id}/show", name="publicidad_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Publicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Publicidad entity.
     *
     * @Route("/new", name="publicidad_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Publicidad();
        
        $tipo=$this->getRequest()->query->get('tipo',  Publicidad::$NIVEL1);
        
        $max=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:Publicidad')->getMaxPosicion($tipo);
        if(!is_null($max)){
            $entity->setPosicion($max+1);
        }else{
            $entity->setPosicion(1);
        }
        $entity->setTipoPublicidad($tipo);
        
        $form   = $this->createForm(new PublicidadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Publicidad entity.
     *
     * @Route("/create", name="publicidad_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Publicidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Publicidad();
        $form = $this->createForm(new PublicidadType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publicidad_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Publicidad entity.
     *
     * @Route("/{id}/edit", name="publicidad_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Publicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicidad entity.');
        }

        $editForm = $this->createForm(new PublicidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Publicidad entity.
     *
     * @Route("/{id}/update", name="publicidad_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Publicidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Publicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PublicidadType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publicidad_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Publicidad entity.
     *
     * @Route("/{id}/delete", name="publicidad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:Publicidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publicidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publicidad'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
