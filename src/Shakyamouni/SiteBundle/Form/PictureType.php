<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PictureType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('position', 'integer')
                ->add('title', 'text')
                ->add('subtitle', 'text')
                ->add('file')
                ->add('subCategory', 'entity', array(
                    'class' => 'ShakyamouniMenuBundle:subCategory',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getSubCategoriesbyTitreASC();
                    },
                ))
                ->add('subCategoryEvent', 'entity', array(
                    'class' => 'ShakyamouniMenuBundle:subCategoryEvent',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getSubCategoriesEventbyTitreASC();
                    },
                ))
                ->add('articleevent', 'entity', array(
                    'class' => 'ShakyamouniSiteBundle:ArticleEvent',
                    'empty_value' => '',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getFutureArticleEventsQuery();
                    },
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\SiteBundle\Entity\Picture'
        ));
    }

    public function getName() {
        return 'shakyamouni_sitebundle_picturetype';
    }

}
