<?php

namespace Richpolis\GalMonBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoriasGaleriaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriasGaleriaRepository extends EntityRepository
{
    public function getMaxPosicion($tipo=0){
        $em=$this->getEntityManager();
        if($tipo==0){
            $query=$em->createQuery('
                SELECT COUNT(p.posicion) as value 
                FROM RichpolisGalMonBundle:CategoriasGaleria p 
                ORDER BY p.posicion ASC
            ');
        }else{
            $query=$em->createQuery('
                SELECT COUNT(p.posicion) as value 
                FROM RichpolisGalMonBundle:CategoriasGaleria p 
                WHERE p.tipoCategoria=:tipo 
                ORDER BY p.posicion ASC
            ')->setParameter('tipo', $tipo);
        }
        $max=$query->getResult();
        return $max[0]['value'];
    }
    
    public function getCategoriaActualPorTipoCategoria($tipoCategoria){
        $em=$this->getEntityManager();
        $query=$em->createQuery('
                    SELECT p FROM RichpolisGalMonBundle:CategoriasGaleria p 
                    LEFT JOIN p.galerias g 
                    WHERE p.tipoCategoria = :tipo 
                    AND p.isActive = :active 
                    ORDER BY g.posicion DESC
                ')->setParameters(array('tipo'=> $tipoCategoria,'active'=>true));
        $categoria=$query->getResult();
        return $categoria[0];
    }
    
    public function getCategoriaConGaleriaPorId($categoria_id,$active=true){
        $em=$this->getEntityManager();
        $query=$em->createQuery('
                    SELECT p 
                    FROM RichpolisGalMonBundle:CategoriasGaleria p 
                    LEFT JOIN p.galerias g 
                    WHERE p.id = :categoria 
                    AND p.isActive = :active 
                    ORDER BY g.posicion DESC
                ')->setParameters(array('categoria'=> $categoria_id,'active'=>true));
        $categoria=$query->getResult();
        return $categoria[0];
    }
    public function getCategoriasPorTipoCategoria($tipoCategoria,$categoria_actual=0,$active=true){
        $em=$this->getEntityManager();
        $query=$em->createQuery('
                    SELECT p FROM RichpolisGalMonBundle:CategoriasGaleria p
                    WHERE p.tipoCategoria = :tipo 
                    AND p.id <> :actual 
                    AND p.isActive = :active 
                    ORDER BY p.posicion DESC 
                ')->setParameters(array(
                    'tipo'=> $tipoCategoria,
                    "actual"=>$categoria_actual,
                    'active'=>$active
                ));
        return $query->getResult();
    }

    public function getQueryCategoriasPorTipoYActivas($tipoCategoria,$todas=false){
        $query=$this->createQueryBuilder('c')
                    ->where('c.tipoCategoria=:tipo')
                    ->setParameter('tipo', $tipoCategoria)
                    ->orderBy('c.posicion', 'DESC');
        if(!$todas){
            $query->andWhere('c.isActive=:active')
                  ->setParameter('active', true);
        }
        return $query->getQuery();
    }
    
    public function getCategoriasPorTipoYActivas($tipo,$todas=false){
        $query=$this->getQueryCategoriasPorTipoYActivas($tipo, $todas);
        return $query->getResult();
    }
    
}