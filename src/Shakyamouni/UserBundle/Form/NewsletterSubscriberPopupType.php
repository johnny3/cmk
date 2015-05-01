<?php

namespace Shakyamouni\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsletterSubscriberPopupType extends NewsletterSubscriberType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->remove('is_active')
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'footer.newsletter.your_postal_code'
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'footer.newsletter.your_email'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\UserBundle\Entity\NewsletterSubscriber'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_userbundle_newslettersubscriberpopuptype';
    }
}
