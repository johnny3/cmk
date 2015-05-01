<?php

namespace Shakyamouni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\AdminBundle\Entity\NewsletterArticle;
use Shakyamouni\AdminBundle\Form\NewsletterArticleType;

/**
 * NewsletterArticle controller.
 *
 * @Route("/newsletter_article_admin")
 */
class NewsletterArticleController extends Controller {

    /**
     * Lists all NewsletterArticle entities.
     *
     * @Route("/", name="newsletter_article_admin")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniAdminBundle:NewsletterArticle')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a NewsletterArticle entity.
     *
     * @Route("/{id}/show", name="newsletter_article_admin_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:NewsletterArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterArticle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new NewsletterArticle entity.
     *
     * @Route("/new", name="newsletter_article_admin_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NewsletterArticle();
        $form = $this->createForm(new NewsletterArticleType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new NewsletterArticle entity.
     *
     * @Route("/create", name="newsletter_article_admin_create")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:NewsletterArticle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NewsletterArticle();
        $form = $this->createForm(new NewsletterArticleType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->uploadProfilePicture();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newsletter_article_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NewsletterArticle entity.
     *
     * @Route("/{id}/edit", name="newsletter_article_admin_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:NewsletterArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterArticle entity.');
        }

        $editForm = $this->createForm(new NewsletterArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing NewsletterArticle entity.
     *
     * @Route("/{id}/update", name="newsletter_article_admin_update")
     * @Method("POST")
     * @Template("ShakyamouniAdminBundle:NewsletterArticle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:NewsletterArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterArticle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NewsletterArticleType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->uploadProfilePicture();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newsletter_article_admin_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a NewsletterArticle entity.
     *
     * @Route("/{id_article}/delete/{id_newsletter}", name="newsletter_article_admin_delete")
     * @Method("GET")
     */
    public function deleteAction($id_article, $id_newsletter){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniAdminBundle:NewsletterArticle')->find($id_article);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsletterArticle entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('newsletter_admin_show', array('id' => $id_newsletter)));
    }
}
