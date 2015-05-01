<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('createdAt', 'datetime')
//            ->add('updatedAt', 'datetime')
//            ->add('slug')
                ->add('position', 'integer')
                ->add('title', 'text')
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
                ->add('file')
                ->add('pictureSize')
//                ->add('isPicture', 'choice', array(
//                    'choices' => array(
//                        'yes' => 'Oui',
//                        'no' => 'Non'
//                    ),
//                    'preferred_choices' => array('yes'),
//                ))
                ->add('isPicture')
                ->add('isVisible')
                ->add('subCategory')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\SiteBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_sitebundle_articletype';
    }

}
