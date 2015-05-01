<?php

namespace Shakyamouni\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shakyamouni\UserBundle\Entity\NewsletterSubscriber;
use Shakyamouni\UserBundle\Form\NewsletterSubscriberType;

class FooterController extends Controller {

    public function indexAction()
    {
        $infoService = $this->container->get('shakyamouni_site.info');
        $footerInfo = $infoService->getCenterInfo();
        $entity = new NewsletterSubscriber();
        $form = $this->createForm(new NewsletterSubscriberType(), $entity);

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniSiteBundle:Commun:footer.html.twig', array(
                            'footerInfo' => $footerInfo,
                            'form' => $form->createView(),
                        ));
    }

}
