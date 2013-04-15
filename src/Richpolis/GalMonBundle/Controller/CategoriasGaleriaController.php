<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\CategoriasGaleria;
use Richpolis\GalMonBundle\Form\CategoriasGaleriaType;


/**
 * CategoriasGaleria controller.
 *
 * @Route("/backend/categorias/galeria")
 */
class CategoriasGaleriaController extends Controller
{
    protected function getFilters()
    {
        $filters=$this->get('session')->get('filters', array());
        return $filters;
    }
    
    /**
     * Lists all CategoriasGaleria entities.
     *
     * @Route("/", name="categorias_galeria")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $filters = $this->getFilters();

        if(!isset($filters['categorias']))
            $filters['categorias']=CategoriasGaleria::$LO_QUE_ESTOY_VIENDO;

        $query = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                            ->getQueryCategoriasPorTipoYActivas($filters['categorias'],true);
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            10
        );


        
        return array(
            'tipos'         =>  CategoriasGaleria::getArrayTipoCategorias(),
            'tipo_categoria'=>  $filters['categorias'],
            'pagination' => $pagination,
        );
    }
    
    /**
     * Seleccionar un tipo de categoria.
     *
     * @Route("/seleccionar", name="categorias_galeria_seleccionar")
     */
    public function selectAction()
    {
        $filters = $this->getFilters();
        
        if(isset($filters['categorias'])){
            return $this->redirect($this->generateUrl('categorias_galeria'));
        }else{
            return $this->render('RichpolisGalMonBundle:CategoriasGaleria:select.html.twig', array(
                'tipos'  => CategoriasGaleria::getArrayTipoCategorias(),
            ));
        }
    }
    
    /**
     * Mostrar categoria por tipo
     *
     * @Route("/list/{tipo}/tipo", name="categorias_galeria_por_tipo")
     */
    public function porTipoAction($tipo)
    {
        $filters = $this->getFilters();
        if($tipo){
            $filters['categorias']=$tipo;
            $this->get('session')->set('filters',$filters);
            return $this->redirect($this->generateUrl('categorias_galeria'));
        }else{
            if(isset($filters['categorias'])){
                return $this->redirect($this->generateUrl('categorias_galeria'));
            }else{
                return $this->render('RichpolisGalMonBundle:CategoriasGaleria:select.html.twig', array(
                    'tipos'  => CategoriasGaleria::getArrayTipoCategorias(),
                ));
            }
        }        
    }
    

    /**
     * Finds and displays a CategoriasGaleria entity.
     *
     * @Route("/{id}/show", name="categorias_galeria_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $categoria_actual = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                               ->find($id);
        
        $categorias = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriasPorTipoCategoria($categoria_actual->getTipoCategoria(),$categoria_actual->getId());
        
        if (!$categoria_actual) {
            throw $this->createNotFoundException('Unable to find CategoriasGaleria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $categoria_actual,
            'categorias'  => $categorias,
            'tipos'       => CategoriasGaleria::getArrayTipoCategorias(),
            'delete_form' => $deleteForm->createView(),

        );
    }
    
    /**
     * Mostrar categorias segun el tipo.
     *
     * @Route("/show/{tipo}/tipo", name="categorias_galeria_show_tipo")
     * @Template("RichpolisGalMonBundle:CategoriasGaleria:show.html.twig")
     */
    public function showCategoriaAction($tipo)
    {
        
        $categoria_actual=$this->getDoctrine()
                ->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriaActualPorTipoCategoria($tipo);
        $categorias = $this->getDoctrine()
                ->getRepository('RichpolisGalMonBundle:CategoriasGaleria')
                ->getCategoriasPorTipoCategoria($categoria_actual->getTipoCategoria(),$categoria_actual->getId());
        
        if (!$categoria_actual) {
            throw $this->createNotFoundException('Unable to find CategoriasGaleria entity.');
        }

        $deleteForm = $this->createDeleteForm($categoria_actual->getId());

        return array(
            'entity'      => $categoria_actual,
            'categorias'  => $categorias,
            'tipos'       => CategoriasGaleria::getArrayTipoCategorias(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    public function loQueEstoyViendoAction(){
        return $this->forward(
                'RichpolisGalMonBundle:CategoriasGaleria:showCategoria', 
                array('tipo'=>  CategoriasGaleria::$LO_QUE_ESTOY_VIENDO)
                );
    }
    
    public function oficialAction(){
        return $this->forward(
                'RichpolisGalMonBundle:CategoriasGaleria:showCategoria', 
                array('tipo'=>  CategoriasGaleria::$GALERIA_OFICIAL)
                );
    }
    
    public function tusFotosAction(){
        return $this->forward(
                'RichpolisGalMonBundle:CategoriasGaleria:showCategoria', 
                array('tipo'=>  CategoriasGaleria::$TUS_FOTOS)
                );
    }
    
    public function decoraTuPantallaAction(){
        return $this->forward(
                'RichpolisGalMonBundle:CategoriasGaleria:showCategoria', 
                array('tipo'=>  CategoriasGaleria::$DECORA_TU_PANTALLA)
                );
    }

    /**
     * Displays a form to create a new CategoriasGaleria entity.
     *
     * @Route("/new", name="categorias_galeria_new")
     * @Template()
     */
    public function newAction()
    {
        $request=$this->getRequest();
        $tipo=$request->query->get('tipo',0);
        $entity = new CategoriasGaleria();
        $max=$this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')->getMaxPosicion();
        
        if(!is_null($max)){
            $entity->setPosicion($max+1);
        }else{
            $entity->setPosicion(1);
        }
        
        if($tipo>0){
            $entity->setTipoCategoria($tipo);
        }
        
        $form   = $this->createForm(new CategoriasGaleriaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CategoriasGaleria entity.
     *
     * @Route("/create", name="categorias_galeria_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:CategoriasGaleria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CategoriasGaleria();
        $form = $this->createForm(new CategoriasGaleriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categorias_galeria_por_tipo', array('tipo' => $entity->getTipoCategoria())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CategoriasGaleria entity.
     *
     * @Route("/{id}/edit", name="categorias_galeria_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriasGaleria entity.');
        }

        $editForm = $this->createForm(new CategoriasGaleriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CategoriasGaleria entity.
     *
     * @Route("/{id}/update", name="categorias_galeria_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:CategoriasGaleria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriasGaleria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoriasGaleriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categorias_galeria_por_tipo', array('tipo' => $entity.getTipoCategoria())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CategoriasGaleria entity.
     *
     * @Route("/{id}/delete", name="categorias_galeria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:CategoriasGaleria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoriasGaleria entity.');
            }
            
            foreach($entity->getGalerias() as $galeria){
                $em->remove($galeria);
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categorias_galeria'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Galeria de una categoria segun el status del registro.
     *
     * @Route("/galeria/{categoria}/{isActive}", name="categorias_galeria_galeria")
     * @Template()
     */
    public function galeriaAction($categoria,$isActive){
        $em = $this->getDoctrine()->getEntityManager();
        $entities=$em->getRepository('RichpolisGalMonBundle:Galerias')
                ->getGaleriaPorCategoriaYStatus($categoria,$isActive);
        
        return array(
            'entities'=>$entities,
            'gallery_status'=>$isActive
        );
    }
    
    /**
     * Ordenar registros.
     *
     * @Route("/ordenar", name="categorias_galeria_ordenar")
     */
    public function ordenarGaleriaAction()
    {
        $request=$this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $categoria = $this->getDoctrine()->getRepository('RichpolisGalMonBundle:CategoriasGaleria')->find($request->request->get("categoria"));
            $registro_order = $request->query->get('registro');
            $em=$this->getDoctrine()->getEntityManager();
            $result['ok']="ok";
            foreach($registro_order as $order=>$id)
            {
                $registro=  $this->getDoctrine()->getRepository('RichpolisGalMonBundle:Galerias')->find($id);
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
