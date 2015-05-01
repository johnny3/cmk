<?php

namespace Shakyamouni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class NewsletterArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', 'integer', array(
                'attr'=> array('class'=>'text-input small-input'),
                'label' => 'Position'
            )) 
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
            ->add('subCategory', 'entity', array(
                    'class' => 'ShakyamouniMenuBundle:SubCategory',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getPublishedSubCategoriesQuery();
                    },
                    'label' => 'Sous catégorie',
                ))
            ->add('articleLie', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:Article',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getArticleCoursHebdoQuery();
                    },
                    'label' => 'Article lié',
                ))
            ->add('file', 'file', array(
                'label' => 'Bannière'
            ))
            ->add('body', 'textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced'
                  )))
            ->add('isReservationLink', 'checkbox', array(
                'label' => 'Lien de réservation ?')
               )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\AdminBundle\Entity\NewsletterArticle'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_adminbundle_newsletterarticletype';
    }
}
