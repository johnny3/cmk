<?php

namespace Shakyamouni\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\MenuBundle\Entity\SubCategoryEvent;
use Shakyamouni\SiteBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Response;

/**
 * SubCategoryEvent controller.
 *
 * @Route("/evenements")
 */
class SubCategoryEventFrontController extends Controller {

    /**
     * Finds and displays a SubCategoryEvent entity.
     *
     * @Route("/{subcategory_slug}", name="subcategoryevent_show")
     * @Route("/")
     * @Template("ShakyamouniMenuBundle:SubCategoryEventFront:show.html.twig")
     */
    public function showAction($subcategory_slug = null)
    {
        $em = $this->getDoctrine()->getManager();

        $category_event = $em->getRepository('ShakyamouniMenuBundle:Category')->getEventCategory();
        $subCategoriesEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findAll();

        if (empty($subcategory_slug)) {
            $subCategoriesEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->getVisibleFirstSubCategoryEvent(1);
            return $this->redirect($this->generateUrl('subcategoryevent_show', array('subcategory_slug' => $subCategoriesEvent[0]->getSlug())));
        }
        else {
            $subCategory = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findOneBySlug($subcategory_slug);
            $subCategory_events = $em->getRepository('ShakyamouniSiteBundle:Event')->getEventsBySubcategory($subcategory_slug);
        }

        if (!$subCategory) {
            if ('dev' == $this->get('kernel')->getEnvironment()) {
                throw $this->createNotFoundException('Unable to find SubCategoryEvent entity.');
            } else {
//                $response = new Response();
                $response = $this->render('ShakyamouniSiteBundle:Errors:error.404.html.twig', array());
                $response->setStatusCode(404);
                return $response;
            }
        }

        return array(
            'category_event' => $category_event,
            'subCategory' => $subCategory,
            'subCategoriesEvent' => $subCategoriesEvent,
            'subCategory_events' => $subCategory_events
        );
    }

    public function subCategoriesEventsByCategoryEventWithPositionAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subCategoriesEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->getSubCategoriesEventbyPositionASC();

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Sidebar:subCategoriesEventByCategoryEventWithPosition.html.twig', array(
                            'subCategoriesEvent' => $subCategoriesEvent,
                                )
        );
    }
    
    public function visibleSubCategoryEventByCategoryAction($category_slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $category = $em->getRepository('ShakyamouniMenuBundle:Category')->findOneBySlug($category_slug);
        
        $subCategoryEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')
                          ->getVisibleFirstSubCategoryEvent();

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Menu:firstVisibleSubCategoryEvent.html.twig', array(
                            'category' => $category,
                            'subCategoryEvent' => $subCategoryEvent[0]
                                )
        );
    }

}
