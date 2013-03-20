<?php

namespace Richpolis\GalMonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\GalMonBundle\Entity\CategoriasGaleria;

class CategoriasGaleriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoria')
            ->add('tipoCategoria','choice',array(
                'label'=>'Tipo',
                'empty_value'=>false,
                'choices'=>CategoriasGaleria::getArrayTipoCategorias(),
                'preferred_choices'=>CategoriasGaleria::getPreferedTipoCategoria()
                ))
            ->add('posicion',"hidden")
            ->add('isActive',null,array('label'=>'Activo?'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\GalMonBundle\Entity\CategoriasGaleria'
        ));
    }

    public function getName()
    {
        return 'richpolis_galmonbundle_categoriasgaleriatype';
    }
}
