<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('eventDateStart', 'datetime')
                ->add('eventDateEnd', 'datetime')
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
                ->add('reservationLink', 'text')
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
                ->add('subCategoryEvent')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\SiteBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_sitebundle_eventtype';
    }

}
