<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\MenuBundle\Entity\SubCategoryEvent;
use Shakyamouni\MenuBundle\Form\SubCategoryEventType;

/**
 * SubCategoryEvent controller.
 *
 * @Route("/subcategoryevent_admin")
 */
class SubCategoryEventAdminController extends Controller {

    /**
     * Lists all SubCategoryEvent entities.
     *
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all SubCategoryEvent entities.
     *
     * @Route("/list", name="subcategoryevent_admin")
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SubCategoryEvent entity.
     *
     * @Route("/{id}/show", name="subcategoryevent_admin_show")
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoryEvent entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new SubCategoryEvent entity.
     *
     * @Route("/new", name="subcategoryevent_admin_new")
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new SubCategoryEvent();
        $form = $this->createForm(new SubCategoryEventType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new SubCategoryEvent entity.
     *
     * @Route("/create", name="subcategoryevent_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SubCategoryEvent();
        $form = $this->createForm(new SubCategoryEventType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategoryevent_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SubCategoryEvent entity.
     *
     * @Route("/{id}/edit", name="subcategoryevent_admin_edit")
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoryEvent entity.');
        }

        $editForm = $this->createForm(new SubCategoryEventType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing SubCategoryEvent entity.
     *
     * @Route("/{id}/update", name="subcategoryevent_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SubCategoryEventAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoryEvent entity.');
        }

        $editForm = $this->createForm(new SubCategoryEventType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategoryevent_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a SubCategoryEvent entity.
     *
     * @Route("/{id}/delete", name="subcategoryevent_admin_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoryEvent entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('subcategoryevent_admin'));
    }

}
