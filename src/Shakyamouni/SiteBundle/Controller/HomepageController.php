<?php

namespace Shakyamouni\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Query;

class HomepageController extends Controller {

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction($max = 30) {
        $em = $this->getDoctrine()
                ->getManager();

        $sliders = $em->getRepository('ShakyamouniSiteBundle:Slider')
                ->getSliders($max);

        $blocks = $em->getRepository('ShakyamouniSiteBundle:Homepage')->find(1);

//        $pictures = $em->getRepository('ShakyamouniSiteBundle:Picture')->findAll();

//        $future_events = $em->getRepository('ShakyamouniSiteBundle:Event')
//                ->getFutureEventsQuery()
//                ->andWhere('e.isVisible = :is_visible')
//                ->setParameter('is_visible', true)
//                ->andWhere('e.id NOT IN (:ids)')
//                ->setParameter('ids', array(3,4))
//                ->getQuery()
//                ->getResult();
//        
//        $future_articles_events = $em->getRepository('ShakyamouniSiteBundle:ArticleEvent')
//                ->getFutureArticleEventsQuery()
//                ->andWhere('ae.isVisible = :is_visible')
//                ->setParameter('is_visible', true)
//                ->getQuery()
//                ->getResult();
//        
//        $future_merge_events = array_merge($future_events, $future_articles_events);

        return $this->container->get('templating')->renderResponse('ShakyamouniSiteBundle:Homepage:index.html.twig', array(
//                    'pictures' => $pictures,
                    'sliders' => $sliders,
                //    'future_merge_events' => $future_merge_events,
                    'blocks' => $blocks,
                ));
    }

}
