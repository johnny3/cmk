<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Shakyamouni\UserBundle\Entity\NewsletterSubscriber;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberType;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberTownType;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberFilterType;

/**
 * NewsletterSubscriber controller.
 *
 * @Route("/newslettersubscriber_admin")
 */
class NewsletterSubscriberAdminController extends Controller {

    public function parse_csv_file($file, $columnheadings = false, $delimiter =
    ',', $enclosure = "\"")
    {

        $row = 1;
        $rows = array();
        $handle = fopen($file, 'r');

        while (($data = fgetcsv($handle, 1000, $delimiter, $enclosure)) !==
        FALSE) {

            if (!($columnheadings == false) && ($row == 1)) {
                $headingTexts = $data;
            } elseif (!($columnheadings == false)) {
                foreach ($data as $key => $value) {
                    unset($data[$key]);
                    if ($headingTexts[$key] == 'DATE') {
                        $data[$headingTexts[$key]] = substr($value, 0, 10);
                    } else {
                        $data[$headingTexts[$key]] = $value;
                    }
                }
                $rows[] = $data;
            } else {
                $rows[] = $data;
            }
            $row++;
        }

        fclose($handle);
        return $rows;
    }

    /**
     * Lists all NewsletterSubscriber entities.
     *
     * @Route("/upload-csv", name="newslettersubscriber_upload")
     */
    public function uploadCsvAction()
    {
        $em = $this->getDoctrine()->getManager();

        $path = $this->get('kernel')->getRootDir() . '/../web/uploads/newsletter/xyz_em_list.csv';
        $row = $this->parse_csv_file($path, false);

        foreach ($row as $val) {
            $nameValueForm = isset($val[1]) ? $val[1] : '';
            $emailValueForm = $val[0];

            $isRegistredEmail = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findOneByEmail($emailValueForm);

            if (NULL == $isRegistredEmail) {
                $entity = new NewsletterSubscriber();

                if (!empty($nameValueForm)) {
                    $entity->setName($nameValueForm);
                }

                $entity->setEmail($emailValueForm);
                $entity->setIsActive(false);
                $em->persist($entity);
                $em->flush();

                echo 'subscriber ' . $entity->getEmail() . ' inséré<br/>';
            }
        }

        return new Response();
    }

    /**
     * Send Latest Newsletter.
     *
     * @Route("/send", name="newslettersubscriber_send")
     */
    public function sendNewsletter()
    {
        $em = $this->getDoctrine()->getManager();
        $emails = $em->getRepository($this->container->getParameter('lexik_mailer.email_entity.class'))->findAll();

        $emailsTab = array();
        foreach ($emails as $key => $value) {
            if (substr($value->getReference(), 0, 11) == 'newsletter-') {
                $emailsTab[$key] = $value->getReference();
            }
        }

        $latestNewsletter = end($emailsTab);

        // récupération de tous les inscrits actifs
        $activeSubscribers = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findActiveSubscribers();

        // envoi newsletter à chaque abonné actif
        foreach ($activeSubscribers as $subscriberEmail) {
            $to = $subscriberEmail;
            $token = sha1(md5($subscriberEmail));
            $url_unsubscribe = $this->generateUrl('newslettersubscriber_unsubscribe', array('token' => $token, 'email' => $subscriberEmail), true);
            $params = array('url_unsubscribe' => $url_unsubscribe);
            $locale = 'fr';
            $message = $this->container->get('lexik_mailer.message_factory')->get($latestNewsletter, $to, $params, $locale);
            $this->container->get('mailer')->send($message);
            
            $filetoOpen = $this->get('kernel')->getRootDir() . '/../web/uploads/newsletter/newsletter-sent-' . date('Ymd') . '.log';
	
            $fp = fopen($filetoOpen, 'a');
            
            $line = date("Y-m-d H:i:s") . " email sent to subscriber_email: " . $subscriberEmail;

            if (false !== $fp) {
                fwrite($fp, date('d/m/Y H:i:s') . ";" . $line . "\n");
                fclose($fp);
            }
        }

        $message = "Newsletter envoyée !";

        return new Response($message);
    }

    /**
     * Lists all NewsletterSubscriber entities.
     *
     * @Route("/", name="newslettersubscriber_admin")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberAdmin:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($request->isMethod('POST')) {
           $values = $request->request->get('shakyamouni_userbundle_newslettersubscriberfiltertype');
           $email = $values['email'];
        }
        else {
            $email = null;
        }

        $entity = new NewsletterSubscriber();
        $form = $this->createForm(new NewsletterSubscriberFilterType(), $entity);

        if (null == $email){
            $entities = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findAll();
        }
        else {
            $entities = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findSubscriberByEmail($email);
        }
        
        $numberOfActiveSubscribers = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->getNumberOfActiveSubscribers(true);
        $numberOfInactiveSubscribers = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->getNumberOfActiveSubscribers(false);

        return array(
            'entities' => $entities,
            'form' => $form->createView(),
            'numberOfActiveSubscribers' => $numberOfActiveSubscribers,
            'numberOfInactiveSubscribers' => $numberOfInactiveSubscribers,
        );
    }
    
    /**
     * Displays a form to create a new NewsletterSubscriber entity.
     *
     * @Route("/new", name="newslettersubscriber_admin_new")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new NewsletterSubscriber();
//        $form = $this->createForm(new NewsletterSubscriberType(), $entity);
        $form = $this->createForm(new NewsletterSubscriberTownType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new NewsletterSubscriber entity.
     *
     * @Route("/create", name="newslettersubscriber_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NewsletterSubscriber();
//        $form = $this->createForm(new NewsletterSubscriberType(), $entity);
        $form = $this->createForm(new NewsletterSubscriberTownType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newslettersubscriber_admin', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NewsletterSubscriber entity.
     *
     * @Route("/{id}/edit", name="newslettersubscriber_admin_edit")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterSubscriber entity.');
        }

//        $editForm = $this->createForm(new NewsletterSubscriberType(), $entity);
        $editForm = $this->createForm(new NewsletterSubscriberTownType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing NewsletterSubscriber entity.
     *
     * @Route("/{id}/update", name="newslettersubscriber_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterSubscriber entity.');
        }

//        $editForm = $this->createForm(new NewsletterSubscriberType(), $entity);
        $editForm = $this->createForm(new NewsletterSubscriberTownType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newslettersubscriber_admin', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a NewsletterSubscriber entity.
     *
     * @Route("/{id}/delete", name="newslettersubscriber_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterSubscriber entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('newslettersubscriber_admin'));
    }
    
    /**
     * Lists all Donateur entities.
     *
     * @Route("/export_csv", name="export_csv")
     */
    public function exportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriber')->findActiveSubscribers();
        
        $subscriberTab = array();
        $headers = array('EMAIL');
        $handle = fopen('php://memory', 'r+');
        fputcsv($handle, $headers, ';');
        unset($headers);
        
        foreach ($query as $i=>$subscriber){
            $subscriberTab[$i]['email'] = $subscriber;
            fputcsv($handle, $subscriberTab[$i], ';');
            unset($subscriberTab[$i]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        
        fclose($handle);
        
        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export-'. date('d-m-Y') .'.csv"'
        ));
    }

}
