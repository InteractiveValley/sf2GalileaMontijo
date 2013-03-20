<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
    
}
