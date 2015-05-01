<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\Article;
use Shakyamouni\SiteBundle\Form\ArticleType;

/**
 * Article controller.
 *
 * @Route("/article_admin")
 */
class ArticleAdminController extends Controller {

    /**
     * Lists all Article entities.
     *
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->getSubCategoriesWithArticles();

        return array(
            'entities' => $entities,
        );
    }

    public function articlesBySubCategoryAction($subcategory_slug)
    {
        $articles = $this->getDoctrine()
                ->getRepository('ShakyamouniSiteBundle:Article')
                ->getArticlesBySubCategory($subcategory_slug);

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniAdminBundle:ArticleAdmin:articlesBySubCategory.html.twig', array(
                            'articles' => $articles,
                                )
        );
    }

    /**
     * Lists all Article entities.
     *
     * @Route("/list", name="article_admin")
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:Article')->findAllBySubCategoryASCAndTitleASC();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{id}/show", name="article_admin_show")
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        return array(
            'article' => $entity,
        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="article_admin_new")
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/create", name="article_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

         //   $isVisibleValueForm = $form->getData()->getIsVisible();
            $isPictureValueForm = $form->getData()->getIsPicture();
            $fileValueForm = $form->getData()->file;

            if ($isPictureValueForm && !empty($fileValueForm)) {
           // if ('yes' === $isPictureValueForm && !empty($fileValueForm)) {
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

            return $this->redirect($this->generateUrl('article_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_admin_edit")
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}/update", name="article_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:ArticleAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

   //         $isVisibleValueForm = $editForm->getData()->getIsVisible();
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

            return $this->redirect($this->generateUrl('article_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}/delete", name="article_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('article_admin'));
    }

}
