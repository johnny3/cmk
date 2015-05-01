<?php

namespace Shakyamouni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pm', 'entity', array(
                    'class' => 'ShakyamouniAdminBundle:Calendar',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getLastActiveCalendarUpdatedQuery();
                    },
                    'label' => 'Programme mensuel',
                ))
            ->add('isPmUploadable')
            ->add('mailObject')
            ->add('sentence', 'textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced'
                  )))
            ->add('manualTitle')
            ->add('newsletterarticles', 'collection', array('type'         => new NewsletterArticleType(),
                                                            'allow_add'    => true,
                                                            'allow_delete' => true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\AdminBundle\Entity\Newsletter'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_adminbundle_newslettertype';
    }
}
