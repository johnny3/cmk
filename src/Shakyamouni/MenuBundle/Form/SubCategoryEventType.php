<?php

namespace Shakyamouni\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubCategoryEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', 'integer')
            ->add('title', 'text')
            ->add('isVisible')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\MenuBundle\Entity\SubCategoryEvent'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_menubundle_subcategoryeventtype';
    }
}
