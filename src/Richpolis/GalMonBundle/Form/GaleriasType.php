<?php

namespace Richpolis\GalMonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Richpolis\GalMonBundle\Repository\CategoriasGaleriaRepository;
use Richpolis\GalMonBundle\Repository\FansRepository;

class GaleriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('file','file',array('label'=>'Imagen'))
            ->add('thumbnail','hidden')
            ->add('posicion','hidden')
            ->add('categoria','entity', array(
                'class' => 'RichpolisGalMonBundle:CategoriasGaleria',
                'query_builder' => function(CategoriasGaleriaRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.id', 'ASC');
                },
                'property' => 'categoria',
                'label'=>'Categoria',
                'multiple'=>false
            ))
            
            
            ->add('fan','entity', array(
                'class' => 'RichpolisGalMonBundle:Fans',
                'query_builder' => function(FansRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.id', 'ASC');
                },
                'property' => 'nombre',
                'label'=>'Fan',
                'multiple'=>false
            ))
            
            ->add('isActive',null,array('label'=>'Activo?'))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\GalMonBundle\Entity\Galerias'
        ));
    }

    public function getName()
    {
        return 'richpolis_galmonbundle_galeriastype';
    }
}
