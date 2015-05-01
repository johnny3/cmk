<?php

namespace Shakyamouni\SiteBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class InfoService {
    protected $container;
    
    public function setContainer($container) {
        $this->container = $container;
    }
    
    public function getCenterInfo() {
        return $this->container->get('doctrine')->getRepository('ShakyamouniSiteBundle:Info')->getInfo();
    }
    
    
}
