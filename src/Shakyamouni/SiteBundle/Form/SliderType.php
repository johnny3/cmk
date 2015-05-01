<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SliderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('position', 'integer')
                ->add('title', 'text')
                ->add('subtitle', 'text')
                ->add('file')
                ->add('isCaption')
                ->add('event', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:Event',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getFutureEventsQuery();
                    },
                ))
                ->add('article', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:Article',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getArticleCoursHebdoQuery();
                    },
                ))
                ->add('articleevent', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:ArticleEvent',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getFutureArticleEventsQuery();
                    },
                ))
                ->add('subcategory', 'entity', array(
                    'class' => 'ShakyamouniMenuBundle:SubCategory',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getPublishedSubCategoriesQuery();
                    },
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\SiteBundle\Entity\Slider'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_sitebundle_slidertype';
    }

}
