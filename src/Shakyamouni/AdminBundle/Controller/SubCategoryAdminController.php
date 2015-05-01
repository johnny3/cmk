<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\MenuBundle\Entity\SubCategory;
use Shakyamouni\MenuBundle\Form\SubCategoryType;

/**
 * SubCategory controller.
 *
 * @Route("/subcategory_admin")
 */
class SubCategoryAdminController extends Controller {

    /**
     * Lists all SubCategory entities.
     *
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:Category')->getCategoryOrSubCategoryExceptCalendarContactEvent();

        return array(
            'entities' => $entities,
        );
    }
    
    public function subCategoriesByCategoryWithPositionAction($category_slug)
    {
        $subCategories = $this->getDoctrine()
                ->getRepository('ShakyamouniMenuBundle:SubCategory')
                ->getSubCategoriesByCategory($category_slug);


        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniAdminBundle:SubCategoryAdmin:subCategoriesByCategoryWithPosition.html.twig', array(
                            'subCategories' => $subCategories,
                                )
        );
    }

    /**
     * Lists all SubCategory entities.
     *
     * @Route("/list", name="subcategory_admin")
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->getSubCategoriesByCategoryAndPositionOrder();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SubCategory entity.
     *
     * @Route("/{id}/show", name="subcategory_admin_show")
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new SubCategory entity.
     *
     * @Route("/new", name="subcategory_admin_new")
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new SubCategory();
        $form = $this->createForm(new SubCategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new SubCategory entity.
     *
     * @Route("/create", name="subcategory_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SubCategory();
        $form = $this->createForm(new SubCategoryType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

    //        $isVisibleValueForm = $form->getData()->getIsVisible();
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
            
//            if ('yes' === $isVisibleValueForm){
//                $entity->setIsVisible(true);
//            }
//            else {
//                $entity->setIsVisible(false);
//            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategory_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SubCategory entity.
     *
     * @Route("/{id}/edit", name="subcategory_admin_edit")
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        $editForm = $this->createForm(new SubCategoryType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing SubCategory entity.
     *
     * @Route("/{id}/update", name="subcategory_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:SubCategoryAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        $editForm = $this->createForm(new SubCategoryType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            

     //       $isVisibleValueForm = $editForm->getData()->getIsVisible();
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
                return $this->redirect($this->generateUrl('article_admin_edit', array('id' => $id)));
            } else {
                $entity->setPicture(NULL);
            }
            
//            if ('yes' === $isVisibleValueForm){
//                $entity->setIsVisible(true);
//            }
//            else {
//                $entity->setIsVisible(false);
//            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategory_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a SubCategory entity.
     *
     * @Route("/{id}/delete", name="subcategory_admin_delete")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('subcategory_admin'));
    }

}
