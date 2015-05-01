<?php

namespace Shakyamouni\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\UserBundle\Entity\NewsletterSubscriber;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberType;

/**
 * NewsletterSubscriber controller.
 *
 * @Route("/newslettersubscriber")
 */
class NewsletterSubscriberController extends Controller {
    
    /**
     * Creates a new NewsletterSubscriber entity.
     *
     * @Route("/create", name="newslettersubscriber_ajax_create")
     * @Method("POST")
     */
    public function createAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $nameValueForm = $request->request->get('name');
            $emailValueForm = $request->request->get('email');
            $token = sha1(md5($emailValueForm));
            $isRegistredEmail = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findOneByEmail($emailValueForm);
            if (NULL == $isRegistredEmail) {
                $entity = new NewsletterSubscriber();
                
                if (NULL !== $nameValueForm) {
                    $entity->setName($nameValueForm);
                }

                $entity->setEmail($emailValueForm);
                $entity->setIsActive(false);
                $em->persist($entity);
                $em->flush();

                // envoi mail de confirmation
                $to = $entity->getEmail();
                $url = $this->generateUrl('newslettersubscriber_subscription', array('token' => $token, 'email' => $emailValueForm), true);
                $params = array('entity' => $entity, 'url' => $url);
                $locale = 'fr';
                $message = $this->container->get('lexik_mailer.message_factory')->get('confirmation-newsletter', $to, $params, $locale);
                $this->get('mailer')->send($message);

                $msg =  $this->get('translator')->trans('newsletter.subscription_confirmed');
            }
            elseif(NULL != $isRegistredEmail && TRUE != $isRegistredEmail->getIsActive()){
                $msg = $this->get('translator')->trans('newsletter.not_activated');
            }
            else {
                $msg = $this->get('translator')->trans('newsletter.already_activated');
            }

            return new Response($msg);
        }
    }
    
    /**
     * Subscription confirmation.
     *
     * @Route("/subscription/{token}/{email}", name="newslettersubscriber_subscription")
     * @Template("ShakyamouniSiteBundle:General:subscribeSuccessfull.html.twig")
     * @Method("GET")
     */
    public function newSubscriptionAction($token, $email)
    {
        $em = $this->getDoctrine()->getManager();
        $subscriber = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findOneByEmail($email);

        if (NULL !== $subscriber && $token == sha1(md5($email))) {
            $subscriber->setIsActive(true);
            $em->flush();

            // envoi mail de confirmation d'inscription
            $to = $email;
            $params = array('entity' => $subscriber);
            $locale = 'fr';
            $message = $this->container->get('lexik_mailer.message_factory')->get('confirmation-newsletter-active', $to, $params, $locale);
            $this->container->get('mailer')->send($message);
            
//            $message = '<p>Merci pour votre inscription à notre bulletin mensuel.<br/>
//                        Votre abonnement est maintenant actif.</p>';
            $message = $this->get('translator')->trans('newsletter.subscription_confirmed_browser');
        }
        else {
//            $message = '<p>Votre inscription n\'a pu être confirmé à cause d\un problème d\'e-mail ou de token incorrect(s).<br/>
//                        Veuillez utiliser le lien donné dans le mail.</p>';
            $message = $this->get('translator')->trans('newsletter.subscription_unconfirmed_browser');
        }

        return array('message' => $message);
    }

    /**
     * Unsubscribe a subscribed reader.
     *
     * @Route("/unsubscribe/{token}/{email}", name="newslettersubscriber_unsubscribe")
     * @Template("ShakyamouniSiteBundle:General:unsubscribeSuccessfull.html.twig")
     * @Method("GET")
     */
    public function unsubscribeAction($token, $email)
    {
//        $em = $this->getDoctrine()->getManager();
//        $subscriber = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findOneByEmail($email);
//
//        if (NULL != $subscriber && $token == sha1(md5($email))) {
//            $subscriber->setIsActive(false);
//            $em->persist($subscriber);
//            $em->flush();
//
//            // envoi mail de confirmation de désabonnement
//            $to = $subscriber->getEmail();
//            $params = array('entity' => $subscriber);
//            $locale = 'fr';
//            $message = $this->container->get('lexik_mailer.message_factory')->get('confirmation-desabonnement-newsletter', $to, $params, $locale);
//            $this->container->get('mailer')->send($message);
//        }

//        $message = '<p>Vous êtes à présent désinscrit de la newsletter. Nous espérons vous revoir bientôt.</p>';
        $message = $this->get('translator')->trans('newsletter.unsubscription_not_available');
        
        return array('message' => $message);
    }

}
