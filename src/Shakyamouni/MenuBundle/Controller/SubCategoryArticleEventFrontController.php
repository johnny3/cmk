<?php

namespace Shakyamouni\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\MenuBundle\Entity\SubCategoryEvent;
use Shakyamouni\SiteBundle\Entity\ArticleEvent;
use Symfony\Component\HttpFoundation\Response;

/**
 * SubCategoryEvent controller.
 *
 * @Route("/evenements")
 */
class SubCategoryArticleEventFrontController extends Controller {

    /**
     * Finds and displays a SubCategoryArticleEvent entity.
     *
     * @Route("/{subcategory_slug}/subEvent/{event_slug}", name="subcategoryarticleevent_show")
     * @Template("ShakyamouniMenuBundle:SubCategoryArticleEventFront:show.html.twig")
     */
    public function showAction($subcategory_slug, $event_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $category_event = $em->getRepository('ShakyamouniMenuBundle:Category')->getEventCategory(); // pour sidebar
        $subCategoriesEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findAll(); // pour breadcrumbs
        
        if (empty($subcategory_slug)) {
            $subCategoriesEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->getFirstSubCategoryEvent(1);  // pour breadcrumbs
            return $this->redirect($this->generateUrl('subcategoryevent_show', array('subcategory_slug' => $subCategoriesEvent->getSlug())));
        }
        else {
            $subCategory = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findOneBySlug($subcategory_slug);  // pour breadcrumbs
            
//            if (empty($event_slug)) {
//                 $articleEvent = $em->getRepository('ShakyamouniMenuBundle:ArticleEvent')->getFirstArticleEventBySubCategory($subcategory_slug);  // pour breadcrumbs
//                 return $this->redirect($this->generateUrl('subcategoryarticleevent_show', array('subcategory_slug' => $subCategoriesEvent->getSlug(), 'event_slug' => $articleEvent)));
//             }
//             else {
                 $articlesEvent = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->getArticlesEventsBySubCategoryEventAndEvent($subcategory_slug, $event_slug);
//             }
        }

        if (!$subCategory || !$articlesEvent) {
            if ('dev' == $this->get('kernel')->getEnvironment()) {
                if (!$subCategory) {
                    throw $this->createNotFoundException('Unable to find SubCategoryEvent entity.');
                }
                elseif (!$articlesEvent){
                    throw $this->createNotFoundException('Unable to find Event entity.');
                } 
            } else {
                $response = new Response();
                $response = $this->render('ShakyamouniSiteBundle:Errors:error.404.html.twig', array());
                $response->setStatusCode(404);
                return $response;
            }
        }

        return array(
            'category_event' => $category_event,
            'subCategory' => $subCategory,
            'subCategoriesEvent' => $subCategoriesEvent,
            'articlesEvent' => $articlesEvent
        );
    }

    public function articlesEventsByCategoryEventAndEventWithPositionAction($subcategory_slug, $event_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $articlesEvent = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')->getArticlesEventsBySubCategoryEventAndEvent($subcategory_slug, $event_slug);

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Sidebar:articlesEventByCategoryEventAndEventWithDate.html.twig', array(
                            'articlesEvent' => $articlesEvent,
                            'subcategory_slug' => $subcategory_slug,
                            'event_slug' => $event_slug,
                                )
        );
    }

}
