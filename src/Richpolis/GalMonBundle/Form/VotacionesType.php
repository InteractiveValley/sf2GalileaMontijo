<?php

namespace Richpolis\GalMonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VotacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('file','file',array("label"=>"Imagen"))
            ->add('thumbnail','hidden')
            ->add('posicion','hidden')
            ->add('votacion','integer')
            ->add('semana','entity', array(
                'class' => 'RichpolisGalMonBundle:SemanaVotaciones',
                'property' => 'tema',
                'label'=>'Tema semana',
            ))
            ->add('fan','entity', array(
                'class' => 'RichpolisGalMonBundle:Fans',
                'property' => 'nombre',
                'label'=>'Fan'
            ))
            ->add('isActive',null,array('label'=>'Activo?'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\GalMonBundle\Entity\Votaciones'
        ));
    }

    public function getName()
    {
        return 'richpolis_galmonbundle_votacionestype';
    }
}
