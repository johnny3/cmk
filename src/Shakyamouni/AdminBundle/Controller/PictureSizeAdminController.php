<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\PictureSize;
use Shakyamouni\SiteBundle\Form\PictureSizeType;

/**
 * PictureSize controller.
 *
 * @Route("/picturesize_admin")
 */
class PictureSizeAdminController extends Controller {

    /**
     * Lists all PictureSize entities.
     *
     * @Route("/list", name="picturesize_admin")
     * @Template("ShakyamouniAdminBundle:PictureSizeAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:PictureSize')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a PictureSize entity.
     *
     * @Route("/{id}/show", name="picturesize_admin_show")
     * @Template("ShakyamouniAdminBundle:PictureSizeAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSize entity.');
        }
        
        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new PictureSize entity.
     *
     * @Route("/new", name="picturesize_admin_new")
     * @Template("ShakyamouniAdminBundle:PictureSizeAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new PictureSize();
        $form = $this->createForm(new PictureSizeType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new PictureSize entity.
     *
     * @Route("/create", name="picturesize_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:PictureSizeAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PictureSize();
        $form = $this->createForm(new PictureSizeType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('picturesize_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PictureSize entity.
     *
     * @Route("/{id}/edit", name="picturesize_admin_edit")
     * @Template("ShakyamouniAdminBundle:PictureSizeAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSize entity.');
        }

        $editForm = $this->createForm(new PictureSizeType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing PictureSize entity.
     *
     * @Route("/{id}/update", name="picturesize_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:PictureSizeAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSize entity.');
        }

        $editForm = $this->createForm(new PictureSizeType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('picturesize_admin_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a PictureSize entity.
     *
     * @Route("/{id}/delete", name="picturesize_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSize entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('picturesize_admin'));
    }
}
