<?php

namespace Shakyamouni\MenuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shakyamouni\MenuBundle\Entity\SubCategory;
use Shakyamouni\MenuBundle\Form\SubCategoryType;
use Symfony\Component\HttpFoundation\Response;

/**
 * SubCategory controller.
 *
 * @Route("/cat")
 */
class SubCategoryFrontController extends Controller {

    /**
     * Finds and displays a SubCategory entity.
     *
     * @Route("/{category_slug}/sous-cat/{subcategory_slug}", name="subcategory_show")
     * @Template("ShakyamouniMenuBundle:SubCategoryFront:show.html.twig")
     */
    public function showAction($category_slug, $subcategory_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $subCategory = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->getSubcategoryByCategorySlugAndSubCategorySlug($category_slug, $subcategory_slug);

        if (!$subCategory) {
            if ('dev' == $this->get('kernel')->getEnvironment()) {
                throw $this->createNotFoundException('Unable to find SubCategory entity.');
            } else {
                $response = new Response();
                $response = $this->render('ShakyamouniSiteBundle:Errors:error.404.html.twig', array());
                $response->setStatusCode(404);
                return $response;
            }
        }
        
        return array(
                'subCategory' => $subCategory
            );
        
    }

    public function subCategoriesByCategoryWithPositionAction($category_slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $subCategories = $em->getRepository('ShakyamouniMenuBundle:SubCategory')
                            ->getSubCategoriesByCategory($category_slug);


        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Sidebar:subCategoriesByCategoryWithPosition.html.twig', array(
                            'subCategories' => $subCategories,
                                )
        );
    }

    public function articlesBySubCategoryWithPositionAction($subcategory_slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $articlesByPosition = $em->getRepository('ShakyamouniSiteBundle:Article')
                            ->getArticlesBySubCategoryWithPosition($subcategory_slug);


        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Sidebar:articlesBySubCategoryWithPosition.html.twig', array(
                            'articlesByPosition' => $articlesByPosition,
                            'subcategory_slug' => $subcategory_slug,
                                )
        );
    }

    public function articlesWithPositionAction($subcategory_slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $articlesByPosition = $em->getRepository('ShakyamouniSiteBundle:Article')
                            ->getArticlesBySubCategoryWithPosition($subcategory_slug);


        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:SubCategoryFront:articlesWithPosition.html.twig', array(
                            'articlesByPosition' => $articlesByPosition)
        );
    }

    public function visibleSubCategoryByCategoryAction($category_slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $subCategory = $em->getRepository('ShakyamouniMenuBundle:SubCategory')
                          ->getVisibleFirstSubCategoryByCategory($category_slug);

        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Menu:firstVisibleSubCategoryByCategory.html.twig', array(
                            'category' => $subCategory[0]->getCategory(),
                            'subCategory' => $subCategory[0]
                                )
        );
    }

}
