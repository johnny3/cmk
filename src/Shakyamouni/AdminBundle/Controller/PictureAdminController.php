<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\Picture;
use Shakyamouni\SiteBundle\Form\PictureType;

/**
 * Picture controller.
 *
 * @Route("/picture_admin")
 */
class PictureAdminController extends Controller {

    /**
     * Lists all Picture entities.
     *
     * @Route("/", name="picture_admin")
     * @Template("ShakyamouniAdminBundle:PictureAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:Picture')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Picture entity.
     *
     * @Route("/new", name="picture_admin_new")
     * @Template("ShakyamouniAdminBundle:PictureAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Picture();
        $form = $this->createForm(new PictureType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Picture entity.
     *
     * @Route("/create", name="picture_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:PictureAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Picture();
        $form = $this->createForm(new PictureType(), $entity);
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

            return $this->redirect($this->generateUrl('picture_admin'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Picture entity.
     *
     * @Route("/{id}/edit", name="picture_admin_edit")
     * @Template("ShakyamouniAdminBundle:PictureAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $editForm = $this->createForm(new PictureType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Picture entity.
     *
     * @Route("/{id}/update", name="picture_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:PictureAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $editForm = $this->createForm(new PictureType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $fileValueForm = $editForm->getData()->file;

            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('picture_admin', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Picture entity.
     *
     * @Route("/{id}/delete", name="picture_admin_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('picture_admin'));
    }

}
