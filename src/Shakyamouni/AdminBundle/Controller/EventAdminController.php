<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\Event;
use Shakyamouni\SiteBundle\Form\EventType;

/**
 * Event controller.
 *
 * @Route("/event_admin")
 */
class EventAdminController extends Controller {

    /**
     * Lists all Event entities.
     *
     * @Template("ShakyamouniAdminBundle:EventAdmin:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->getSubCategoriesEventWithEvents();

        return array(
            'entities' => $entities,
        );
    }

    public function eventsBySubCategoryEventAction($subcategory_slug)
    {
        $events = $this->getDoctrine()
                ->getRepository('ShakyamouniSiteBundle:Event')
                ->getEventsBySubcategory($subcategory_slug);

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniAdminBundle:EventAdmin:eventsBySubCategoryEvent.html.twig', array(
                            'events' => $events,
                                )
        );
    }

    /**
     * Lists all Event entities.
     *
     * @Route("/list", name="event_admin")
     * @Template("ShakyamouniAdminBundle:EventAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniSiteBundle:Event')->findAllBySubCategoryASCAndTitleASC();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{id}/show", name="event_admin_show")
     * @Template("ShakyamouniAdminBundle:EventAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/new", name="event_admin_new")
     * @Template("ShakyamouniAdminBundle:EventAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Event();
        $form = $this->createForm(new EventType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Event entity.
     *
     * @Route("/create", name="event_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:EventAdmin:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Event();
        $form = $this->createForm(new EventType(), $entity);
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

            return $this->redirect($this->generateUrl('event_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{id}/edit", name="event_admin_edit")
     * @Template("ShakyamouniAdminBundle:EventAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createForm(new EventType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Event entity.
     *
     * @Route("/{id}/update", name="event_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:EventAdmin:index.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }
        
        $editForm = $this->createForm(new EventType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $isVisibleValueForm = $editForm->getData()->getIsVisible();
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

            return $this->redirect($this->generateUrl('event_admin_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Event entity.
     *
     * @Route("/{id}/delete", name="event_admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('event_admin'));
    }

}
