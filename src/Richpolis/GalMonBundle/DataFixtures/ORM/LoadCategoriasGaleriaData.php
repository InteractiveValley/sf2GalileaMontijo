<?php

// src/Ens/JobeetBundle/DataFixtures/ORM/LoadCategoryData.php
namespace Richpolis\GalMonBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Richpolis\GalMonBundle\Entity\CategoriasGaleria;
 
class LoadCategoriasGaleriaData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $oficial = new CategoriasGaleria();
    $oficial->setCategoria('Galeria Oficial 1');
    $oficial->setTipoCategoria(CategoriasGaleria::$GALERIA_OFICIAL);
    $oficial->setPosicion(1);
 
    $tusfotos = new CategoriasGaleria();
    $tusfotos->setCategoria('Tus Fotos 1');
    $tusfotos->setTipoCategoria(CategoriasGaleria::$TUS_FOTOS);
    $tusfotos->setPosicion(2);
    
    $loqueestoyviendo = new CategoriasGaleria();
    $loqueestoyviendo->setCategoria('Lo que estoy viendo 1');
    $loqueestoyviendo->setTipoCategoria(CategoriasGaleria::$LO_QUE_ESTOY_VIENDO);
    $loqueestoyviendo->setPosicion(3);
    
    $decoratupantalla = new CategoriasGaleria();
    $decoratupantalla->setCategoria('Decora tu pantalla 1');
    $decoratupantalla->setTipoCategoria(CategoriasGaleria::$DECORA_TU_PANTALLA);
    $decoratupantalla->setPosicion(4);
 
    $em->persist($oficial);
    $em->persist($tusfotos);
    $em->persist($loqueestoyviendo);
    $em->persist($decoratupantalla);
    
    $em->flush();
 
    /*$this->addReference('category-design', $design);
    $this->addReference('category-programming', $programming);
    $this->addReference('category-manager', $manager);
    $this->addReference('category-administrator', $administrator);*/
  }
 
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}