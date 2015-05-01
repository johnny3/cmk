<?php

namespace Shakyamouni\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\AdminBundle\Entity\Newsletter;
use Shakyamouni\AdminBundle\Form\NewsletterType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Newsletter controller.
 *
 * @Route("/newsletter")
 */
class NewsletterController extends Controller {
    
     /**
     * Finds and displays a Newsletter overview.
     *
     * @Route("/{id}/overview", name="newsletter_overview")
     * @Template("ShakyamouniUserBundle:Newsletter:showBrowserOverview.html.twig")
     */
    public function showOverviewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShakyamouniAdminBundle:Newsletter')->find($id);
        $footerInfo = $em->getRepository('ShakyamouniSiteBundle:Info')->getInfo();
        $newletterArticles = $em->getRepository('ShakyamouniAdminBundle:NewsletterArticle')->getArticlesByPosition($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Newsletter entity.');
        }

        return array(
            'newsletter' => $entity,
            'newsletter_articles' => $newletterArticles,
            'pm' => $entity->getPm()->getCalendar(),
            'footerInfo' => $footerInfo,
        );
    }

}
