<?php

namespace Shakyamouni\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubCategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('position', 'integer')
                ->add('title', 'text')
//                ->add('isPicture', 'choice', array(
//                    'choices' => array(
//                        'yes' => 'Oui',
//                        'no' => 'Non'
//                    ),
//                    'preferred_choices' => array('yes'),
//                ))
                ->add('isPicture')
                ->add('isVisible')
                ->add('file')
                ->add('pictureSize')
                ->add('body', 'textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // simple, advanced, bbcode
                        )))
                ->add('category')
                ->add('slideshow')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\MenuBundle\Entity\SubCategory'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_menubundle_subcategorytype';
    }

}
