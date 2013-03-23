<?php

namespace Richpolis\GalMonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\GalMonBundle\Entity\Publicaciones;

class PublicacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('publicacion','genemu_tinymce',array(
                    'attr'=>array('cols' => 50,'rows' => 10,))
                 )
            ->add('file','file',array(
                'label'=>'Imagen',
                ))
            ->add('linkVideo','url',array('label'=>'Link de Video','required'=>false))
            ->add('posicion','hidden')
            ->add('tipoPublicacion','choice',array(
                'label'=>'Tipo',
                'empty_value'=>false,
                'choices'=>Publicaciones::getArrayTipoPublicaciones(),
                'preferred_choices'=>Publicaciones::getPreferedTipoPublicacion(),
                ))
            ->add('isActive',null,array('label'=>'Activo?'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\GalMonBundle\Entity\Publicaciones'
        ));
    }

    public function getName()
    {
        return 'richpolis_galmonbundle_publicacionestype';
    }
}
