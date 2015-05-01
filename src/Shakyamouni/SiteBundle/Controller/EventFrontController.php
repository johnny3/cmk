<?php

namespace Shakyamouni\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class EventFrontController extends Controller {
  public function eventsBySubcategoryEventByDateAction($subcategory_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('ShakyamouniSiteBundle:Event')->getEventBySubcategorySlugByDateAsc($subcategory_slug);
        
        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Sidebar:futureEventByCategoryEvent.html.twig', array(
                            'events' => $events,
                            'subcategory_slug' => $subcategory_slug,
                        ));
    }
}

