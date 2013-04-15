<?php

namespace Richpolis\GalMonBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * GaleriasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GaleriasRepository extends EntityRepository
{
    
    public function getMaxPosicion($tipo_categoria=0){
        $em=$this->getEntityManager();
        if($tipo_categoria==0){
        $query=$em->createQuery('
            SELECT MAX(g.posicion) as value 
            FROM RichpolisGalMonBundle:Galerias g 
            ORDER BY g.posicion ASC
            ');
        }else{
        $query=$em->createQuery('
            SELECT MAX(g.posicion) as value 
            FROM RichpolisGalMonBundle:Galerias g 
            WHERE g.tipoCategoria=:tipo 
            ORDER BY g.posicion ASC
            ')->setParameter('tipo', $tipo_categoria);
        }
        $max=$query->getResult();
        return $max[0]['value'];
    }
    
    public function getRegistroPorIdConCategoria($id){
        $em=$this->getEntityManager();
        $query=$em->createQuery('
            SELECT g  
            FROM RichpolisGalMonBundle:Galerias g 
            LEFT JOIN g.categoria c 
            LEFT JOIN g.fan f 
            WHERE g.id=:id
            ')->setParameters(array('id'=>$id));
        return $query->getSingleResult();
    }
    
    public function getQueryGaleriaPorCategoriaYStatus($categoria,$active){
        $em=$this->getEntityManager();
        $query=$em->createQuery('
            SELECT g  
            FROM RichpolisGalMonBundle:Galerias g 
            WHERE g.isActive=:active 
            AND g.categoria=:categoria 
            ORDER BY g.posicion ASC
            ')->setParameters(array('categoria'=>$categoria,'active'=>$active));
        return $query;
    }
    
    public function getGaleriaPorCategoriaYStatus($categoria,$active){
        $query=$this->getQueryGaleriaPorCategoriaYStatus($categoria, $active);
        return $query->getResult();
    }
}