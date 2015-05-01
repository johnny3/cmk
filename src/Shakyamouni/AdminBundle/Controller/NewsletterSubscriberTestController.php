<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\UserBundle\Entity\NewsletterSubscriberTest;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberTestType;

/**
 * NewsletterSubscriberTest controller.
 *
 * @Route("/newslettersubscribertest_admin")
 */
class NewsletterSubscriberTestController extends Controller
{
    /**
     * Lists all NewsletterSubscriberTest entities.
     *
     * @Route("/", name="newslettersubscribertest_admin")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberTestAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriberTest')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new NewsletterSubscriberTest entity.
     *
     * @Route("/new", name="newslettersubscribertest_admin_new")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberTestAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new NewsletterSubscriberTest();
        $form   = $this->createForm(new NewsletterSubscriberTestType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new NewsletterSubscriberTest entity.
     *
     * @Route("/create", name="newslettersubscribertest_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberTestAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new NewsletterSubscriberTest();
        $form = $this->createForm(new NewsletterSubscriberTestType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newslettersubscribertest_admin'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NewsletterSubscriberTest entity.
     *
     * @Route("/{id}/edit", name="newslettersubscribertest_admin_edit")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberTestAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriberTest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterSubscriberTest entity.');
        }

        $editForm = $this->createForm(new NewsletterSubscriberTestType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing NewsletterSubscriberTest entity.
     *
     * @Route("/{id}/update", name="newslettersubscribertest_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:NewsletterSubscriberTestAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriberTest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterSubscriberTest entity.');
        }

        $editForm = $this->createForm(new NewsletterSubscriberTestType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newslettersubscribertest_admin'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a NewsletterSubscriberTest entity.
     *
     * @Route("/{id}/delete", name="newslettersubscribertest_admin_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniUserBundle:NewsletterSubscriberTest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterSubscriberTest entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('newslettersubscribertest_admin'));
    }
}
