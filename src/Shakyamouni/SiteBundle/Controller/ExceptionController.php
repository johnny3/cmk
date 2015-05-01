<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shakyamouni\SiteBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * ExceptionController.
 *
 */
class ExceptionController extends ContainerAware
{
    /**
     * Converts an Exception to a Response.
     *
     * @return Response
     *
     * @throws \InvalidArgumentException When the exception template does not exist
     * @Template("ShakyamouniSiteBundle:Errors:error.500.html.twig")
     */
    public function showAction()
    {
        return array();        
    }
}
