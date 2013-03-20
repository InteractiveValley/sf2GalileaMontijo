<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="RichpolisGalMonBundle_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
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
