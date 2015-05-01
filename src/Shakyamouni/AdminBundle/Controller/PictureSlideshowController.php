<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Entity\PictureSlideshow;
use Shakyamouni\SiteBundle\Form\PictureSlideshowType;

/**
 * PictureSlideshow controller.
 *
 * @Route("/pictures_slideshow_admin")
 */
class PictureSlideshowController extends Controller {

    /**
     * Lists all PictureSlideshow entities.
     *
     * @Route("/", name="pictures_slideshow_admin")
     * @Template("ShakyamouniAdminBundle:PictureSlideshowAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('ShakyamouniSiteBundle:PictureSlideshow')->findAll();
        $entities = $em->getRepository('ShakyamouniSiteBundle:PictureSlideshow')->getPicturesBySlideShowAndPositionOrder();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new PictureSlideshow entity.
     *
     * @Route("/new", name="pictures_slideshow_admin_new")
     * @Template("ShakyamouniAdminBundle:PictureSlideshowAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new PictureSlideshow();
        $form = $this->createForm(new PictureSlideshowType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new PictureSlideshow entity.
     *
     * @Route("/create", name="pictures_slideshow_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:PictureSlideshowAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PictureSlideshow();
        $form = $this->createForm(new PictureSlideshowType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $fileValueForm = $form->getData()->file;
            
            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            } else {
                $referer = $request->headers->get('referer');
                $this->get('session')->getFlashBag()->add('notice', 'Vous n\'avez pas sélectionné d\'image.');
                return array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                );
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pictures_slideshow_admin'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PictureSlideshow entity.
     *
     * @Route("/{id}/edit", name="pictures_slideshow_admin_edit")
     * @Template("ShakyamouniAdminBundle:PictureSlideshowAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSlideshow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSlideshow entity.');
        }

        $editForm = $this->createForm(new PictureSlideshowType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing PictureSlideshow entity.
     *
     * @Route("/{id}/update", name="pictures_slideshow_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:PictureSlideshowAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSlideshow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSlideshow entity.');
        }

        $editForm = $this->createForm(new PictureSlideshowType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $fileValueForm = $editForm->getData()->file;

            if (!empty($fileValueForm)) {
                $entity->uploadProfilePicture();
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pictures_slideshow_admin', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a PictureSlideshow entity.
     *
     * @Route("/{id}/delete", name="pictures_slideshow_admin_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniSiteBundle:PictureSlideshow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PictureSlideshow entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('pictures_slideshow_admin'));
    }

}
