<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\AdminBundle\Entity\Subscription;
use Shakyamouni\AdminBundle\Form\SubscriptionType;

/**
 * Subscription controller.
 *
 * @Route("/subscription_admin")
 */
class SubscriptionAdminController extends Controller
{
    /**
     * Lists all Subscription entities.
     *
     * @Route("/", name="subscription_admin")
     * @Template("ShakyamouniAdminBundle:SubscriptionAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniAdminBundle:Subscription')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Subscription entity.
     *
     * @Route("/{id}/show", name="subscription_admin_show")
     * @Template("ShakyamouniAdminBundle:SubscriptionAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Subscription')->find($id);
        $subscribers = $em->getRepository('ShakyamouniUserBundle:SubscriptionEvent')->findBy(array('hasPayed' => true, 'subscription' => $entity));
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscription entity.');
        }

        return array(
            'entity'      => $entity,
            'subscribers'      => $subscribers,
        );
    }

    /**
     * Displays a form to create a new Subscription entity.
     *
     * @Route("/new", name="subscription_admin_new")
     * @Template("ShakyamouniAdminBundle:SubscriptionAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Subscription();
        $form   = $this->createForm(new SubscriptionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Subscription entity.
     *
     * @Route("/create", name="subscription_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SubscriptionAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Subscription();
        $form = $this->createForm(new SubscriptionType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subscription_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Subscription entity.
     *
     * @Route("/{id}/edit", name="subscription_admin_edit")
     * @Template("ShakyamouniAdminBundle:SubscriptionAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Subscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscription entity.');
        }

        $editForm = $this->createForm(new SubscriptionType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Subscription entity.
     *
     * @Route("/{id}/update", name="subscription_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:Subscription:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Subscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscription entity.');
        }

        $editForm = $this->createForm(new SubscriptionType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subscription_admin_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Subscription entity.
     *
     * @Route("/{id}/delete", name="subscription_admin_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniAdminBundle:Subscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscription entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('subscription_admin'));
    }
}
