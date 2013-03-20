<?php

namespace Richpolis\GalMonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NoticiasController extends Controller
{
    /**
     * @Route("/noticias", name="RichpolisGalMonBundle_noticias")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/noticias/{page}", name="RichpolisGalMonBundle_noticias_pagina")
     * @Template("RichpolisGalMonBundle:Noticias:index.html.twig")
     */
    public function paginaAction($page)
    {
        return array();
    }
    
}
