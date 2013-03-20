<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\GalMonBundle\Entity\Votaciones;
use Richpolis\GalMonBundle\Form\VotacionesType;

/**
 * Votaciones controller.
 *
 * @Route("/backend/votaciones")
 */
class VotacionesController extends Controller
{
    /**
     * Lists all Votaciones entities.
     *
     * @Route("/", name="votaciones")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RichpolisGalMonBundle:Votaciones')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Votaciones entity.
     *
     * @Route("/{id}/show", name="votaciones_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Votaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Votaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Votaciones entity.
     *
     * @Route("/new", name="votaciones_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Votaciones();
        $form   = $this->createForm(new VotacionesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Votaciones entity.
     *
     * @Route("/create", name="votaciones_create")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Votaciones:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Votaciones();
        $form = $this->createForm(new VotacionesType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('votaciones_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Votaciones entity.
     *
     * @Route("/{id}/edit", name="votaciones_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Votaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Votaciones entity.');
        }

        $editForm = $this->createForm(new VotacionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Votaciones entity.
     *
     * @Route("/{id}/update", name="votaciones_update")
     * @Method("POST")
     * @Template("RichpolisGalMonBundle:Votaciones:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RichpolisGalMonBundle:Votaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Votaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VotacionesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('votaciones_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Votaciones entity.
     *
     * @Route("/{id}/delete", name="votaciones_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RichpolisGalMonBundle:Votaciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Votaciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('votaciones'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * upload registro a galeria.
     *
     * @Route("/upload/registro/galeria", name="votaciones_upload")
     */
    public function uploadAction($semana_id){
        
       // list of valid extensions, ex. array("jpeg", "xml", "bmp")
       $allowedExtensions = array("jpeg","png","gif","jpg","flv","mp4","avi");
       // max file size in bytes
       $sizeLimit = 6 * 1024 * 1024;
       $request=$this->get("request");
       $uploader = new qqFileUploader($allowedExtensions, $sizeLimit,$request->server);
       $uploads= $this->container->getParameter('richpolis_galmon_uploads');
       $result = $uploader->handleUpload($uploads."/votaciones/");
       
       // to pass data through iframe you will need to encode all html tags
       /*****************************************************************/
       //$file = $request->getParameter("qqfile");
       $em = $this->getDoctrine()->getEntityManager();
       $max = $em->getRepository('RichpolisGalMonBundle:Votaciones')->getMaxPosicion();
       $semana=$em->getRepository('RichpolisGalMonBundle:SemanaVotaciones')->find($semana_id);
       $fan=$em->getRepository('RichpolisGalMonBundle:Fans')->find(1);
       if(isset($result["success"])){
           $registro = new Votaciones();
           $registro->setImagen($result["filename"]);
           $registro->setThumbnail($result["filename"]);
           $registro->setTitulo($result["titulo"]);
           $registro->setIsActive(true);
           $registro->setPosicion($max+1);
           $registro->setSemana($semana);
           $registro->setFan($fan);
           
           //unset($result["filename"],$result['original'],$result['titulo'],$result['contenido']);
           $em->persist($registro);
           $em->flush();
        }
                    
        // create a JSON-response with a 200 status code
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    
    /**
     * upload registro a galeria.
     *
     * @Route("/mostrar/registros", name="votaciones_galeria")
     * @Template("RichpolisGalMonBundl:SemanaVotaciones:galeria.html.twig")
     */
    public function galeriaAction($categoria,$isActive){
        $em = $this->getDoctrine()->getEntityManager();
        $entities=$em->getRepository('RichpolisGalMonBundle:Votaciones')->getGaleriaPorCategoriaYStatus($categoria_id,$is_active);
        
        return array(
            'entities'          =>  $entities,
            'gallery_status'    =>  $isActive
        );
    }
    
    /**
     * actualizar datos del registro.
     *
     * @Route("/actualizar/registro/galeria", name="galerias_update_registro")
     */
    public function updateRegistroGaleriaAction(){
        $request=$this->getRequest();
        if ($request->getMethod() == 'POST') {
            $id=$request->request->get('id');
            $titulo=$request->request->get('titulo');
        }elseif($request->getMethod() == 'GET'){
            $id=$request->query->get('id');
            $titulo=$request->query->get('titulo');
        }
        $em = $this->getDoctrine()->getEntityManager();
        $registro = $em->getRepository('RichpolisGalMonBundle:Galerias')->find($id);
        $registro->setTitulo($titulo);
        $em->flush();
        
        $template=$this->renderView('RichpolisGalMonBundle:CategoriasGaleria:item.html.twig', array(
            'entity'=>$registro,
        ));
        if($request->isXmlHttpRequest()){
            $response = new Response($template);
            return $response;
        }else{
            
            return $this->redirect($this->generateUrl('galerias'));
        }
    }
    
    /**
     * actualizar datos del registro.
     *
     * @Route("/eliminar/registro/galeria/{id}", name="galerias_delete_registro")
     */
    public function deleteRegistroGaleriaAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('RichpolisGalMonBundle:Galerias')->find($id);
        $request = $this->getRequest();
        $result=array();

        if(!$entity || $request->getMethod() != 'POST'){
            $result['ok']="false";
        }else{
            $em->remove($entity);
            $em->flush();
            $result['ok']="ok";
            $result['id']=$id;
        }
        if($request->isXmlHttpRequest()){
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            
            return $this->redirect($this->generateUrl('galerias'));
        }
    }
    
    /**
     * actualizar datos del registro.
     *
     * @Route("/activar/registro/galeria/{id}", name="galerias_activar")
     */
    public function activarAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('RichpolisGalMonBundle:Galerias')->find($id);
        $request = $this->getRequest();
        $result=array();

        if(!$entity){
            $result['ok']="false";
        }else{
            $entity->setIsActive(true);
            $em->flush();
            $result['ok']="ok";
            $result['id']=$id;
        }
        $template=$this->renderView('RichpolisGalMonBundle:CategoriasGaleria:item.html.twig', array(
            'entity'=>$entity,
        ));

        if($request->isXmlHttpRequest()){
            $result['html']=$template;
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            
            return $this->redirect($this->generateUrl('galerias'));
        }
    }
}
