<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\AdminBundle\Entity\Calendar;
use Shakyamouni\AdminBundle\Form\CalendarType;

/**
 * Calendar controller.
 *
 * @Route("/calendar_admin")
 */
class CalendarController extends Controller
{
    /**
     * Lists all Calendar entities.
     *
     * @Route("/list", name="calendar_admin")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniAdminBundle:Calendar')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Calendar entity.
     *
     * @Route("/{id}/show", name="calendar_admin_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }


        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to create a new Calendar entity.
     *
     * @Route("/new", name="calendar_admin_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Calendar();
        $form   = $this->createForm(new CalendarType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Calendar entity.
     *
     * @Route("/create", name="calendar_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:Calendar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Calendar();
        $form = $this->createForm(new CalendarType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $fileValueForm = $form->getData()->file;

            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            }
            else{
                $this->get('session')->getFlashBag()->add('notice', 'Vous n\'avez pas choisi de fichier.');
                return array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                );
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('calendar_admin'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Calendar entity.
     *
     * @Route("/{id}/edit", name="calendar_admin_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $editForm = $this->createForm(new CalendarType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Calendar entity.
     *
     * @Route("/{id}/update", name="calendar_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:Calendar:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $editForm = $this->createForm(new CalendarType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $fileValueForm = $editForm->getData()->file;
            
            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('calendar_admin_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Calendar entity.
     *
     * @Route("/{id}/delete", name="calendar_admin_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniAdminBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('calendar_admin'));
    }
}
