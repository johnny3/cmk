<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\ArticleEvent;
use Shakyamouni\SiteBundle\Form\ArticleEventType;

/**
 * ArticleEvent controller.
 *
 * @Route("/articleevent_admin")
 */
class ArticleEventAdminController extends Controller {

    /**
     * Lists all ArticleEvent entities.
     *
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('ShakyamouniSiteBundle:Event')->getEventsWithArticleEvents();

        return array(
            'events' => $events,
        );
    }

    public function articleEventsByEventAction($event_slug)
    {
        $articles = $this->getDoctrine()
                ->getRepository('ShakyamouniSiteBundle:ArticleEvent')
                ->getArticleEventsByEvent($event_slug);

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniAdminBundle:ArticleEventAdmin:eventsBySubCategoryEvent.html.twig', array(
                            'articles' => $articles,
                                )
        );
    }

    /**
     * Lists all ArticleEvent entities.
     *
     * @Route("/list", name="articleevent_admin")
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->findAllByEventASCAndTitleASC();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a ArticleEvent entity.
     *
     * @Route("/{id}/show", name="articleevent_admin_show")
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleEvent entity.');
        }

        return array(
            'article' => $entity
        );
    }

    /**
     * Displays a form to create a new ArticleEvent entity.
     *
     * @Route("/new", name="articleevent_admin_new")
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new ArticleEvent();
        $form = $this->createForm(new ArticleEventType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new ArticleEvent entity.
     *
     * @Route("/create", name="articleevent_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ArticleEvent();
        $form = $this->createForm(new ArticleEventType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

      //      $isVisibleValueForm = $form->getData()->getIsVisible();
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

            return $this->redirect($this->generateUrl('articleevent_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ArticleEvent entity.
     *
     * @Route("/{id}/edit", name="articleevent_admin_edit")
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleEvent entity.');
        }

        $editForm = $this->createForm(new ArticleEventType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing ArticleEvent entity.
     *
     * @Route("/{id}/update", name="articleevent_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:ArticleEventAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleEvent entity.');
        }

        $editForm = $this->createForm(new ArticleEventType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

         //   $isVisibleValueForm = $editForm->getData()->getIsVisible();
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

            return $this->redirect($this->generateUrl('articleevent_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a ArticleEvent entity.
     *
     * @Route("/{id}/delete", name="articleevent_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleEvent entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('articleevent_admin'));
    }

}
