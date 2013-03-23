<?php

namespace Richpolis\GalMonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SemanaVotacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('semana','date',array(
                'widget'    => 'single_text',
                'format'    => 'dd-MM-yyyy',
                'label'     => 'Semana',
                'attr'      =>  array('class'=>'datepicker')
                ))
            ->add('tema','text',array('label'=>'Tema'))
            ->add('posicion','hidden')
            ->add('isActive',null,array('label'=>'Activo?'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\GalMonBundle\Entity\SemanaVotaciones'
        ));
    }

    public function getName()
    {
        return 'richpolis_galmonbundle_semanavotacionestype';
    }
}
