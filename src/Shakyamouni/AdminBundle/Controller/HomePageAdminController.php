<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\SiteBundle\Form\HomepageType;

/**
 * Category controller.
 *
 * @Route("/")
 */
class HomePageAdminController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="homepage_admin")
     * @Template("ShakyamouniAdminBundle:HomepageAdmin:home.html.twig")
     */
    public function homeAction()
    {
        return array();
    }

    /**
     * Displays a form to edit an existing Homepage entity.
     *
     * @Route("homepage/{id}/edit", name="homepage_admin_edit")
     * @Template("ShakyamouniAdminBundle:HomepageAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Homepage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Homepage entity.');
        }

        $editForm = $this->createForm(new HomepageType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Homepage entity.
     *
     * @Route("/{id}/update", name="homepage_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniSiteBundle:Homepage:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniSiteBundle:Homepage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Homepage entity.');
        }

        $editForm = $this->createForm(new HomepageType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage_admin_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

}
