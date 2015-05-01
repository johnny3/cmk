<?php

namespace Shakyamouni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subtitle')
            ->add('maxPrice')
            ->add('mediumPrice')
            ->add('lowPrice')
            ->add('percentage')
            ->add('event', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:Event',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getFutureEventsQuery();
                    },
                    'label' => 'Evenement lié',
                ))
            ->add('articleevent', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:ArticleEvent',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getFutureArticleEventsQuery();
                    },
                    'label' => 'Article lié à un événement',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\AdminBundle\Entity\Subscription'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_adminbundle_subscriptiontype';
    }
}
