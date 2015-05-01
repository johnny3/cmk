<?php

namespace Shakyamouni\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PictureSlideshowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file')
            ->add('position', 'integer')
            ->add('title', 'text')
            ->add('slideshow')
  //          ->add('pictureSize')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\SiteBundle\Entity\PictureSlideshow'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_sitebundle_pictureslideshowtype';
    }
}
