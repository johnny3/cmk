<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('centerName', 'text')
            ->add('street', 'text')
            ->add('town', 'text')
            ->add('metro', 'text')
            ->add('building', 'text')
            ->add('interphone', 'text')
            ->add('phoneNumber', 'text')
            ->add('email', 'email')
            ->add('twitter', 'text')
            ->add('facebook', 'text')
            ->add('sentenceFooter1', 'text')
            ->add('sentenceFooter2', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\SiteBundle\Entity\Info'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_sitebundle_infotype';
    }
}
