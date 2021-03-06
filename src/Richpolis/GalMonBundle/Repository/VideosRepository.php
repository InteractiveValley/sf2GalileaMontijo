<?php

namespace Richpolis\GalMonBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VideosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideosRepository extends EntityRepository
{
    public function getMaxPosicion() {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT MAX(v.posicion) as value 
            FROM RichpolisGalMonBundle:Videos v 
            ORDER BY v.posicion ASC
            ');
        $max = $query->getResult();
        return $max[0]['value'];
    }
    
    public function getQueryVideosActivas($todas=false){
        $query=$this->createQueryBuilder('v')
                    ->orderBy('v.posicion', 'ASC');
        if(!$todas){
            $query->andwhere('v.isActive=:active')
                  ->setParameter('active', true);
        }
        return $query->getQuery();
    }
    
    public function getVideosActivas($todas=false){
        $query=$this->getQueryVideosActivas($todas);
        return $query->getResult();
    }
    
    public function getRegistroUpOrDown($posicionRegistro,$up=true){
        // $up = true, $up = false is down
        if($up){
            //up
            $query=$this->createQueryBuilder('p')
                    ->where('p.posicion>:posicion')
                    ->setParameter('posicion', $posicionRegistro)
                    ->orderBy('p.posicion', 'DESC');
        }else{
            //down
            $query=$this->createQueryBuilder('p')
                    ->where('p.posicion<:posicion')
                    ->setParameter('posicion', $posicionRegistro)
                    ->orderBy('p.posicion', 'DESC');
        }
        
        return $query->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
    
    public function getVideoSemana($id=0){
        if($id){
           return $this->find($id);
        }else{
            $query=$this->createQueryBuilder('v');
            $query->orderBy('v.posicion', 'DESC');
            $query->setMaxResults(1);
            return $query->getQuery()->getOneOrNullResult();        
        }
                    
    }
}