<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\Fans;
use Richpolis\GalMonBundle\Form\FansType;

/**
 * Fans controller.
 *
 * @Route("/backend/fans")
 */
class FansController extends Controller
{
    /**
     * Lists all Fans entities.
     *
     * @Route("/", name="fans")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RichpolisGalMonBundle:Fans')
                       ->getFansActivas(true);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Fans entity.
     *
     * @Route("/{id}/show", name="fans_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Fans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fans entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Fans entity.
     *
     * @Route("/new", name="fans_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fans();
        $form   = $this->createForm(new FansType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Fans entity.
     *
     * @Route("/create", name="fans_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Fans:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Fans();
        $form = $this->createForm(new FansType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fans_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Fans entity.
     *
     * @Route("/{id}/edit", name="fans_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Fans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fans entity.');
        }

        $editForm = $this->createForm(new FansType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Fans entity.
     *
     * @Route("/{id}/update", name="fans_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Fans:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Fans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fans entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FansType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fans_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Fans entity.
     *
     * @Route("/{id}/delete", name="fans_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:Fans')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fans entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fans'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
