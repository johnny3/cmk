<?php

namespace Shakyamouni\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/admin/users")
 */
class UserController extends Controller
{
     /**
     * Lists all users.
     *
     * @Route("/", name="user_list")
     * @Template()
     */
    public function indexAction()
    {        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShakyamouniUserBundle:User')->findAll();

        return array(
            'users' => $entities,
        );
    }
    
     /**
     * Delete a user.
     *
     * @Route("/{id}/delete", name="user_delete")
     */
    public function deleteAction($id)
    {        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShakyamouniUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        
        if (in_array('ROLE_SUPER_ADMIN' ,$entity->getRoles())){
            $message = 'Il est impossible de supprimer le super admin.';
            $this->get('session')->getFlashBag()->add('error', $message);
        }
        else {
            $em->remove($entity);
            $em->flush();
            $message = 'L\utilisateur "' . $entity->getUsername() . '" a été supprimé avec succès.';
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('user_list'));
    }
}
