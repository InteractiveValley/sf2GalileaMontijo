<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\ClubsFans;
use Richpolis\GalMonBundle\Form\ClubsFansType;


/**
 * ClubsFans controller.
 *
 * @Route("/backend/clubs/fans")
 */
class ClubsFansController extends Controller
{
    /**
     * Lists all ClubsFans entities.
     *
     * @Route("/", name="clubs_fans")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('RichpolisGalMonBundle:ClubsFans')
                       ->getQueryClubsFansActivas(true);
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            10
        );

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Finds and displays a ClubsFans entity.
     *
     * @Route("/{id}/show", name="clubs_fans_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:ClubsFans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClubsFans entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new ClubsFans entity.
     *
     * @Route("/new", name="clubs_fans_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ClubsFans();
        $form   = $this->createForm(new ClubsFansType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new ClubsFans entity.
     *
     * @Route("/create", name="clubs_fans_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:ClubsFans:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ClubsFans();
        $form = $this->createForm(new ClubsFansType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('clubs_fans_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ClubsFans entity.
     *
     * @Route("/{id}/edit", name="clubs_fans_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:ClubsFans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClubsFans entity.');
        }

        $editForm = $this->createForm(new ClubsFansType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ClubsFans entity.
     *
     * @Route("/{id}/update", name="clubs_fans_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:ClubsFans:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:ClubsFans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClubsFans entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ClubsFansType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('clubs_fans_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ClubsFans entity.
     *
     * @Route("/{id}/delete", name="clubs_fans_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:ClubsFans')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ClubsFans entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('clubs_fans'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Subir registro de ClubsFans.
     *
     * @Route("/{id}/up", name="clubs_fans_up")
     * @Method("GET")
     */
    public function upAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroUp = $em->getRepository('RichpolisGalMonBundle:ClubsFans')->find($id);
        
        if ($registroUp) {
            $registroDown=$em->getRepository('RichpolisGalMonBundle:ClubsFans')->getRegistroUpOrDown($registroUp->getPosicion(),true);
            if ($registroDown) {
                $posicion=$registroUp->getPosicion();
                $registroUp->setPosicion($registroDown->getPosicion());
                $registroDown->setPosicion($posicion);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('clubs_fans',array(
            'page'=>$this->getRequest()->query->get('page', 1)
        )));
    }
    
    /**
     * Subir registro de ClubsFans.
     *
     * @Route("/{id}/down", name="clubs_fans_down")
     * @Method("GET")
     */
    public function downAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroDown = $em->getRepository('RichpolisGalMonBundle:ClubsFans')->find($id);
        
        if ($registroDown) {
            $registroUp=$em->getRepository('RichpolisGalMonBundle:ClubsFans')->getRegistroUpOrDown($registroDown->getPosicion(),false);
            if ($registroUp) {
                $posicion=$registroUp->getPosicion();
                $registroUp->setPosicion($registroDown->getPosicion());
                $registroDown->setPosicion($posicion);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('clubs_fans',array(
            'page'=>$this->getRequest()->query->get('page', 1)
        )));
    }
}
