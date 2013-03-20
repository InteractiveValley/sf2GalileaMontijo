<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\Publicaciones;
use Richpolis\GalMonBundle\Form\PublicacionesType;

/**
 * Publicaciones controller.
 *
 * @Route("/backend/publicaciones")
 */
class PublicacionesController extends Controller
{
    protected function getFilters()
    {
        $filters=$this->get('session')->get('filters', array());
        return $filters;
    }

    /**
     * Lists all Publicaciones entities.
     *
     * @Route("/", name="publicaciones")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $filters = $this->getFilters();

        if(!isset($filters['publicaciones']))
            $filters['publicaciones']=Publicaciones::$NOTICIAS;

        $entities = $em->getRepository('RichpolisGalMonBundle:Publicaciones')
                            ->getPublicacionesPorTipoYActivas($filters['publicaciones'],true);

        return array(
            'entities' => $entities,
            'tipos'  => Publicaciones::getArrayTipoPublicaciones(),
            'tipo_publicacion'=> $filters['publicaciones'],
        );
    }

    /**
     * Seleccionar un tipo de categoria.
     *
     * @Route("/seleccionar", name="publicaciones_seleccionar")
     */
    public function selectAction()
    {
        $filters = $this->getFilters();
        
        if(isset($filters['publicaciones'])){
            return $this->forward('RichpolisGalMonBundle:Publicaciones:index');
        }else{
            return $this->render('RichpolisGalMonBundle:Publicaciones:select.html.twig', array(
                'tipos'  => Publicaciones::getArrayTipoPublicaciones(),
            ));
        }
    }

    /**
     * Mostrar publicaciones por tipo
     *
     * @Route("/list/{tipo}/tipo", name="publicaciones_por_tipo")
     */
    public function porTipoAction($tipo)
    {
        $filters = $this->getFilters();
        if($tipo){
            $filters['publicaciones']=$tipo;
            $this->get('session')->set('filters',$filters);
            return $this->forward('RichpolisGalMonBundle:Publicaciones:index');
        }else{
            if(isset($filters['publicaciones'])){
                return $this->forward('RichpolisGalMonBundle:Publicaciones:index');
            }else{
                return $this->render('RichpolisGalMonBundle:Publicaciones:select.html.twig', array(
                    'tipos'  => Publicaciones::getArrayTipoPublicaciones(),
                ));
            }
        }        
    }


    public function noticiasAction()
    {
        $filters = $this->getFilters();
        $filters['publicaciones']=Publicaciones::$NOTICIAS;
        $this->get('session')->set('filters',$filters);
        return $this->forward('RichpolisGalMonBundle:Publicaciones:index');
    }


    public function trayectoriaAction()
    {
        $filters = $this->getFilters();
        $filters['publicaciones']=Publicaciones::$TRAYECTORIA;
        $this->get('session')->set('filters',$filters);
        return $this->forward('RichpolisGalMonBundle:Publicaciones:index');
    }


    public function configuracionAction()
    {
        $filters = $this->getFilters();
        $filters['publicaciones']=Publicaciones::$CONFIGURACION;
        $this->get('session')->set('filters',$filters);
        return $this->forward('RichpolisGalMonBundle:Publicaciones:index');
    }

    /**
     * Finds and displays a Publicaciones entity.
     *
     * @Route("/{id}/show", name="publicaciones_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Publicaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Publicaciones entity.
     *
     * @Route("/new", name="publicaciones_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Publicaciones();
        
        $tipo=$this->getRequest()->query->get('tipo',Publicaciones::$NOTICIAS);
        
        $max=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:Publicaciones')->getMaxPosicion($tipo);
        if(!is_null($max)){
            $entity->setPosicion($max+1);
        }else{
            $entity->setPosicion(1);
        }
        $entity->setTipoPublicacion($tipo);
        
        $form   = $this->createForm(new PublicacionesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Publicaciones entity.
     *
     * @Route("/create", name="publicaciones_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Publicaciones:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Publicaciones();
        $form = $this->createForm(new PublicacionesType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publicaciones_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Publicaciones entity.
     *
     * @Route("/{id}/edit", name="publicaciones_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Publicaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicaciones entity.');
        }

        $editForm = $this->createForm(new PublicacionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Publicaciones entity.
     *
     * @Route("/{id}/update", name="publicaciones_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Publicaciones:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Publicaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PublicacionesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publicaciones_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Publicaciones entity.
     *
     * @Route("/{id}/delete", name="publicaciones_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:Publicaciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publicaciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publicaciones'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
