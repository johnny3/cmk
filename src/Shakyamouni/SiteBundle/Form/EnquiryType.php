<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EnquiryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('email', 'email');
        $builder->add('subject', 'text');
        $builder->add('contact', 'choice', array(
            'empty_value' => 'Choisissez',
            'choices' => array(
                'centre' => 'Centre',
                'webmaster' => 'Webmaster'
            ),
        ));
        $builder->add('body', 'textarea');
    }

    public function getName()
    {
        return 'shakyamouni_sitebundle_enquirytype';
    }

}