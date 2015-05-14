<?php

namespace Shakyamouni\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class SubscriptionEventType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscription_id = $builder->getData()->getSubscription()->getId();
        $priceValues     = $this->em->getRepository('ShakyamouniAdminBundle:Subscription')->getPricesBySubscription($subscription_id);

        $builder
                ->add('firstname')
                ->add('lastname')
                ->add('cellphone')
                ->add('email')
                ->add('price', 'choice', array(
                    'choices' => $priceValues
                ))
                ->add('additionnalInformation', 'textarea')
                ->add('knowledge', 'choice', array(
                    'choices'     => array(
                        'internet'         => 'subscription.internet.knowledge',
                        'facebook'         => 'subscription.facebook.knowledge',
                        'pub_papier'       => 'subscription.pubpapier.knowledge',
                        'bouche_a_oreille' => 'subscription.boucheaoreille.knowledge',
                        'cmk_france'       => 'subscription.cmkfrance.knowledge',
                        'presse_ecrite'    => 'subscription.cmkfrance.newspaper',
                        'reseaux_sociaux'  => 'subscription.cmkfrance.network',
                        'autre'            => 'subscription.autre.knowledge',
                    ),
                    'required'    => false,
                    'expanded'    => true,
                    'multiple'    => false,
                    'empty_value' => false
                ))
                ->add('isOptin')
                ->add('other');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shakyamouni\UserBundle\Entity\SubscriptionEvent'
        ));
    }

    public function getName()
    {
        return 'shakyamouni_userbundle_subscriptioneventtype';
    }

}