<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\SlideShow;
use Shakyamouni\SiteBundle\Form\SlideShowType;

/**
 * SlideShow controller.
 *
 * @Route("/slideshow_admin")
 */
class SlideShowController extends Controller {

    /**
     * Lists all SlideShow entities.
     *
     * @Route("/", name="slideshow_admin")
     * @Template("ShakyamouniAdminBundle:SlideShowAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:SlideShow')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new SlideShow entity.
     *
     * @Route("/new", name="slideshow_admin_new")
     * @Template("ShakyamouniAdminBundle:SlideShowAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new SlideShow();
        $form = $this->createForm(new SlideShowType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new SlideShow entity.
     *
     * @Route("/create", name="slideshow_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SlideShowAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SlideShow();
        $form = $this->createForm(new SlideShowType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('slideshow_admin', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SlideShow entity.
     *
     * @Route("/{id}/edit", name="slideshow_admin_edit")
     * @Template("ShakyamouniAdminBundle:SlideShowAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:SlideShow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SlideShow entity.');
        }

        $editForm = $this->createForm(new SlideShowType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing SlideShow entity.
     *
     * @Route("/{id}/update", name="slideshow_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SlideShowAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:SlideShow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SlideShow entity.');
        }
        
        $editForm = $this->createForm(new SlideShowType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('slideshow_admin', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a SlideShow entity.
     *
     * @Route("/{id}/delete", name="slideshow_admin_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:SlideShow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SlideShow entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('slideshow_admin'));
    }

}
