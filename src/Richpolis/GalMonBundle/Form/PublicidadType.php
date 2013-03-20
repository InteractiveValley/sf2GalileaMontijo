<?php

namespace Richpolis\GalMonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\GalMonBundle\Entity\Publicidad;

class PublicidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','file',array(
                'label'=>'Archivo',
                ))
            ->add('thumbnail','hidden')
            ->add('link','url')
            ->add('posicion','hidden')
            ->add('tipoPublicidad','choice',array(
                'label'=>'Tipo',
                'empty_value'=>false,
                'choices'=>Publicidad::getArrayTipoPublicidad(),
                'preferred_choices'=>Publicidad::getPreferedTipoPublicidad(),
                'read_only'=>true,
                ))
            ->add('activedAt','genemu_jquerydate',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=> 'Desde',
                ))
            ->add('inativedAt','genemu_jquerydate',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=> 'Hasta'
                ))
            ->add('isActive',null,array('label'=>'Activo?'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\GalMonBundle\Entity\Publicidad'
        ));
    }

    public function getName()
    {
        return 'richpolis_galmonbundle_publicidadtype';
    }
}
