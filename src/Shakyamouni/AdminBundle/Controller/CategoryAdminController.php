<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\MenuBundle\Entity\Category;
use Shakyamouni\MenuBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category_admin")
 */
class CategoryAdminController extends Controller {

    /**
     * Lists all Category entities.
     *
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:Category')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/list", name="category_admin")
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:Category')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="category_admin_show")
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:Category')->find($id);
        
        $category_calendar = $em->getRepository('ShakyamouniMenuBundle:Category')->getCalendarCategory();
        
        if ($entity->getSlug() == $category_calendar->getSlug()) {
            $pm = $this->getDoctrine()
                    ->getRepository('ShakyamouniAdminBundle:Calendar')
                    ->getLastActiveCalendarUpdated();
            
            return array(
                'entity' => $entity,
                'pm' => $pm,
        );
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_admin_new")
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Category();
        $form = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="category_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createForm(new CategoryType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $isPictureValueForm = $form->getData()->getIsPicture();
            $fileValueForm = $form->getData()->file;

//            if ('yes' === $isPictureValueForm && !empty($fileValueForm)) {
            if ($isPictureValueForm && !empty($fileValueForm)) {
                $entity->uploadProfilePicture();
//            } elseif ('yes' === $isPictureValueForm && empty($fileValueForm)) {
            } elseif ($isPictureValueForm && empty($fileValueForm)) {
                $this->get('session')->getFlashBag()->add('notice', 'Vous avez indiqué avoir une image principale mais n\'en avez pas sélectionnée.');
                return array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                );
            } else {
                $entity->setPicture(NULL);
            }

            $em->persist($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('category_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_admin_edit")
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="category_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:CategoryAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $isPictureValueForm = $editForm->getData()->getIsPicture();
            $fileValueForm = $editForm->getData()->file;

//            if ('yes' === $isPictureValueForm && NULL !== $entity->getPicture() && !empty($fileValueForm)) {
            if ($isPictureValueForm && NULL !== $entity->getPicture() && !empty($fileValueForm)) {
                $entity->uploadProfilePicture();
//            } elseif ('yes' === $isPictureValueForm && NULL !== $entity->getPicture() && empty($fileValueForm)) {
            } elseif ($isPictureValueForm && NULL !== $entity->getPicture() && empty($fileValueForm)) {
                $entity->setPicture($entity->getPicture());
//            } elseif ('yes' === $isPictureValueForm && NULL === $entity->getPicture() && !empty($fileValueForm)) {
            } elseif ($isPictureValueForm && NULL === $entity->getPicture() && !empty($fileValueForm)) {
                $entity->uploadProfilePicture();
//            } elseif ('yes' === $isPictureValueForm && NULL === $entity->getPicture() && empty($fileValueForm)) {
            } elseif ($isPictureValueForm && NULL === $entity->getPicture() && empty($fileValueForm)) {
                $this->get('session')->getFlashBag()->add('notice', 'Vous avez indiqué avoir une image principale mais n\'en avez pas sélectionnée.');
                return $this->redirect($this->generateUrl('category_admin_edit', array('id' => $id)));
            } else {
                $entity->setPicture(NULL);
            }

            $em->persist($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('category_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="category_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniMenuBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('category_admin'));
    }
}
