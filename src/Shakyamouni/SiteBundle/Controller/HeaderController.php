<?php

namespace Shakyamouni\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HeaderController extends Controller {

    public function indexAction() {
        $infoService = $this->container->get('shakyamouni_site.info');
        $headerInfo = $infoService->getCenterInfo();

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniSiteBundle:Commun:header.html.twig', array(
                            'headerInfo' => $headerInfo,
        ));
    }
}
