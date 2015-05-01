<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\Slider;
use Shakyamouni\SiteBundle\Form\SliderType;

/**
 * Slider controller.
 *
 * @Route("/slider_admin")
 */
class SliderAdminController extends Controller {

    /**
     * Lists all Slider entities.
     *
     * @Template("ShakyamouniAdminBundle:SliderAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:Slider')->getSliders();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all Slider entities.
     *
     * @Route("/list", name="slider_admin")
     * @Template("ShakyamouniAdminBundle:SliderAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:Slider')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Slider entity.
     *
     * @Route("/{id}/show", name="slider_admin_show")
     * @Template("ShakyamouniAdminBundle:SliderAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new Slider entity.
     *
     * @Route("/new", name="slider_admin_new")
     * @Template("ShakyamouniAdminBundle:SliderAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Slider();
        $form = $this->createForm(new SliderType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Slider entity.
     *
     * @Route("/create", name="slider_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SliderAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Slider();
        $form = $this->createForm(new SliderType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $fileValueForm = $form->getData()->file;

            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            } else {
                $entity->setPicture(NULL);
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('slider_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     * @Route("/{id}/edit", name="slider_admin_edit")
     * @Template("ShakyamouniAdminBundle:SliderAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $editForm = $this->createForm(new SliderType(), $entity);
        
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Slider entity.
     *
     * @Route("/{id}/update", name="slider_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SliderAdmin:new.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $editForm = $this->createForm(new SliderType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $fileValueForm = $editForm->getData()->file;

            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('slider_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Slider entity.
     *
     * @Route("/{id}/delete", name="slider_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('slider_admin'));
    }

}
