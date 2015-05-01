<?php

namespace Shakyamouni\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\AdminBundle\Entity\Subscription;
use Shakyamouni\UserBundle\Entity\NewsletterSubscriber;
use Shakyamouni\AdminBundle\Form\SubscriptionType;
use Shakyamouni\UserBundle\Form\SubscriptionEventType;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberPopupType;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberType;
use Shakyamouni\UserBundle\Entity\SubscriptionEvent;

/**
 * Subscription controller.
 *
 * @Route("/subscription")
 */
class SubscriptionController extends Controller {

    /**
     * Finds and displays a Subscription entity.
     *
     * @Route("/{id}/form", name="subscription_show")
     * @Template("ShakyamouniUserBundle:Subscription:showBrowser.html.twig")
     */
    public function showBrowserAction($id) {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $email_merchant = $this->container->getParameter('merchant_email');
        $is_test_paypal = $this->container->getParameter('is_test_paypal');
        
        $sandbox = '';
        $env = '';
        if ($is_test_paypal){
            $sandbox = 'sandbox.';
            $env = 'preprod.';
            $email_merchant = 'kadampa-merchant@gmail.com';
        }

        $entity = $em->getRepository('ShakyamouniAdminBundle:Subscription')->find($id);
        $subscriptionEvent = new SubscriptionEvent();
        $subscriptionEvent->setSubscription($entity);

        if (!is_null($entity->getEvent())) {
            $description = $em->getRepository('ShakyamouniSiteBundle:Event')->find($entity->getEvent()->getId())->getTitle();
        } else {
            $description = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->find($entity->getArticleEvent()->getId())->getTitle();
        }

        $form = $this->createForm(new SubscriptionEventType($em), $subscriptionEvent);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscription entity.');
        }

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $subscriptionEvent->setHasPayed(false);
            $priceKey = 'get' . ucfirst($form->getData()->getPrice());
            $price = $entity->$priceKey() * ($entity->getPercentage()/100);
            $subscriptionEvent->setPrice('0.00');

            if ($form->isValid()) {
                $em->persist($subscriptionEvent);
                $em->flush();

                return $this->render('ShakyamouniUserBundle:Subscription:paypal.html.twig', array(
                            'action' => 'https://www.'. $sandbox .'paypal.com/cgi-bin/webscr',
                            'return_url' => 'http://www.'. $env .'meditation-paris.org/subscription/thankpage',
                            'cancel_return_url' => 'http://www.'. $env .'meditation-paris.org/subscription/cancelation',
                            'notify_url' => 'http://www.'. $env .'meditation-paris.org/subscription/paypal/process',
                            'amount' => $price,
                            'description' => $description,
                            'subscription_id' => $id,
                            'email_subscriber' => $subscriptionEvent->getEmail(),
                            'user_id' => $subscriptionEvent->getId(),
                            'email_merchant' => $email_merchant,
                            'is_optin' => $subscriptionEvent->getIsOptin(),
                ));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * process paypal transaction.
     *
     * @Route("/paypal/process", name="paypal_process")
     */
    public function paypalProcessAction() {
        $is_test_paypal = $this->container->getParameter('is_test_paypal');      
        $email_account = $this->container->getParameter('merchant_email');
        
        $sandbox = '';
        if ($is_test_paypal){
            $sandbox = 'sandbox.';
            $email_account = 'kadampa-merchant@gmail.com';
        }
        
        $req = 'cmd=_notify-validate';
        $request = $this->getRequest();
        $postValues = $request->request->all();

        foreach ($postValues as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Host: www.". $sandbox ."paypal.com\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen('ssl://www.'. $sandbox .'paypal.com', 443, $errno, $errstr, 30);
        
        $filetoOpen = $this->get('kernel')->getRootDir() . '/../app/logs/subscription-' . date('Ymd') . '.log';

        $fp2 = fopen($filetoOpen, 'a');

        $line = "";
        foreach($postValues as $key => $val){
            $line .= $key . '=>' . $val . "\n";
        }
        
        if (false !== $fp2) {
           fwrite($fp2, date('d/m/Y H:i:s') . ": " . $line . "\n");
        }
        
        $first_name = $postValues['first_name'];
        $last_name = $postValues['last_name'];
        $payment_status = $postValues['payment_status'];
        $payment_amount = $postValues['mc_gross'];
        $payment_currency = $postValues['mc_currency'];
        $receiver_email = $postValues['receiver_email'];
        parse_str($postValues['custom'], $custom);
        
        $filetoOpen = $this->get('kernel')->getRootDir() . '/../app/logs/subscription-' . date('Ymd') . '.log';
        $fp2 = fopen($filetoOpen, 'a');

        $line2 = "";
        foreach($custom as $key => $val){
            $line2 .= $key . '=>' . $val . "\n";
        }
        
        if (false !== $fp2) {
           fwrite($fp2, date('d/m/Y H:i:s') . "=> custom : " . $line2 . "\n");
        }

        if (!$fp) {

        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                if (strcmp($res, "VERIFIED") == 0) {
                    if ($payment_status == "Completed") {
                        
                        if (false !== $fp2) {
                            fwrite($fp2, date('d/m/Y H:i:s') . ": Completed" . "\n");
                            fwrite($fp2, date('d/m/Y H:i:s') . ": email_account: " . $email_account . "\n");
                            fwrite($fp2, date('d/m/Y H:i:s') . ": receiver_email: " . $receiver_email . "\n");
                         }
                        
                        if ($email_account == $receiver_email) {
                            
                            fwrite($fp2, date('d/m/Y H:i:s') . "email_account == receiver_email" . "\n");
                            
                            $em = $this->getDoctrine()->getManager();
                            $subscriptionEvent = $em->getRepository('ShakyamouniUserBundle:SubscriptionEvent')->find($custom['user-id']);
                            $subscriptionEvent->setHasPayed(true);
                            $subscriptionEvent->setPrice($payment_amount);
                            
                            if ($custom['is-optin']){
                                $isRegistredEmail = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findOneByEmail($custom['email-subscriber']);
                            
                                if (NULL == $isRegistredEmail) {
                                    $subscriber = new NewsletterSubscriber();
                                    $subscriber->setName($first_name . ' ' . $last_name);
                                    $subscriber->setEmail($custom['email-subscriber']);
                                    $subscriber->setIsActive(true);
                                    $em->persist($subscriber);
                                }
                                else{
                                    $isRegistredEmail->setIsActive(true);
                                }
                            }
                            
                            $em->flush();
                            
                            $subscription = $em->getRepository('ShakyamouniAdminBundle:Subscription')->find($custom['subscription-id']);
                            if ($subscription->getEvent()){
                                $eventDetails = $subscription->getEvent();
                            }
                            else {
                                $eventDetails = $subscription->getArticleEvent();
                            }
                            
                            $paramsBuyer = array(
                                        'first_name'        => $subscriptionEvent->getFirstname(),
                                        'last_name'         => $subscriptionEvent->getLastname(),
                                        'item_name'         => $eventDetails->getTitle(),
                                        'payment_amount'    => $payment_amount,
                                        'payment_currency'  => $payment_currency,
                                        'merchant_email'    => $receiver_email,
                                        'chapo'             => $eventDetails->getChapo(),
                                    );
                            
                            $line3 = "";
                            foreach($paramsBuyer as $key => $val){
                                $line3 .= $key . '=>' . $val . "\n";
                            }

                            if (false !== $fp2) {
                               fwrite($fp2, date('d/m/Y H:i:s') . "=> paramsBuyer : " . $line3 . "\n");
                            }
                            
                            $payer_email = $custom['email-subscriber'];
                            $message_buyer = $this->container->get('lexik_mailer.message_factory')->get('paiement', $payer_email, $paramsBuyer, 'fr');
                            $this->container->get('mailer')->send($message_buyer);
                            
                            if (false !== $fp2) {
                               fwrite($fp2, date('d/m/Y H:i:s') . "=> payer_email : " . $payer_email . "\n");
                            }
                            //$message = $this->container->getParameter('facebook');
                            $message = 'transaction ok';
                            
                            if (false !== $fp2) {
                               fwrite($fp2, date('d/m/Y H:i:s') . "=> message : " . $message . "\n");
                            }
                            
                            return new Response($message);
                        }
                    } else {
                    	// Statut de paiement: Echec
                    	$message = 'echec paiement';
                    	if (false !== $fp2) {
                               fwrite($fp2, date('d/m/Y H:i:s') . "=> message : " . $message . "\n");
                            }
                    	return new Response($message);
                    }
                    exit();
                } else if (strcmp($res, "INVALID") == 0) {
                    // Transaction invalide
                    $message = 'transaction invalide';
                    if (false !== $fp2) {
                               fwrite($fp2, date('d/m/Y H:i:s') . "=> message : " . $message . "\n");
                            }
                    return new Response($message);
                }
            }
            fclose($fp);
        }
        fclose($fp2);

        return new Response();
    }

    /**
     * process paypal transaction.
     *
     * @Route("/cancelation", name="subscription_cancelation")
     * @Template("ShakyamouniUserBundle:Subscription:notification.html.twig")
     */
    public function paypalCancelationAction() {
        $message = "<p>" . $this->get('translator')->trans('subscription.cancel_confirm') . "</p>";

        return array(
            'message' => $message,
        );
    }

    /**
     * Displays a thankful message.
     *
     * @Route("/thankpage", name="subscription_thankpage")
     * @Template("ShakyamouniUserBundle:Subscription:notification.html.twig")
     */
    public function thankPageAction() {
        $message = "<p>" . $this->get('translator')->trans('subscription.payment_success') . "</p>";

        return array(
            'message' => $message,
        );
    }
    
    /**
     * @Route("/popup", name="subscription_popup")
     * @Template("ShakyamouniUserBundle:Subscription:subscription.html.twig")
     */
    public function subscriptionAction() {
        $entity = new NewsletterSubscriber();
        $form = $this->createForm(new NewsletterSubscriberPopupType(), $entity);
        
        return array(
            'form' => $form->createView(),
        );
    }

}
