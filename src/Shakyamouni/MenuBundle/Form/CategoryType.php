<?php

namespace Shakyamouni\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('position')
                ->add('title')
                ->add('chapo', 'textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'simple' // simple, advanced, bbcode
                        )))
                ->add('body', 'textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // simple, advanced, bbcode
                        )))
//                ->add('isPicture', 'choice', array(
//                    'choices' => array(
//                        'yes' => 'Oui',
//                        'no' => 'Non'
//                    ),
//                    'preferred_choices' => array('yes'),
//                ))
                ->add('isPicture')
                ->add('pictureSize')
                ->add('file')
                ->add('eventCat')
                ->add('contactCat')
                ->add('calendarCat')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\MenuBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_menubundle_categorytype';
    }

}
