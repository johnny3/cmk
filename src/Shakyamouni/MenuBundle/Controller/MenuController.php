<?php

namespace Shakyamouni\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller {

    public function getManager(){
        return $this->getDoctrine()->getManager();
    }
    
    public function menuAction(Request $request)
    {
        $pathInfo = filter_input(INPUT_SERVER, 'PATH_INFO');
        $requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $em = $this->getManager();
        
        if ('prod' != $this->get('kernel')->getEnvironment()){
            $uri = $pathInfo;
        }
        else{
            $uri = $requestUri;
        }
        
        $uri_explode = explode('/', $uri);
        $uri_array_length = count($uri_explode);
        
        if ($uri_array_length > 2){
            $typeCat = $uri_explode[1]; // =cat ou evenements
            $catSlug = $uri_explode[2]; // =slug de la categorie
        }
        else {
            $typeCat = '';
            $catSlug = '';
        }
        
        $categoriesWithArticles = $em->getRepository('ShakyamouniMenuBundle:Category')->getCategoryOrSubCategoryWithArticles();
        
        $subCategoriesEvent = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findAll();
        
        return $this->container->get('templating')
                        ->renderResponse('ShakyamouniMenuBundle:Menu:index.html.twig', 
                                array(
                            'categoriesWithArticles' => $categoriesWithArticles,
                            'subCategoriesEvent' => $subCategoriesEvent,
                            'uri_array_length' => $uri_array_length,
                            'typeCat' => $typeCat,
                            'catSlug' => $catSlug,
                                )
        );
    }
    
    public function breadCrumbsAction(Request $request)
    {
        $pathInfo = filter_input(INPUT_SERVER, 'PATH_INFO');
        $requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $em = $this->getManager();
        
        if ('prod' != $this->get('kernel')->getEnvironment()){
            $uri = $pathInfo;
        }
        else{
            $uri = $requestUri;
        }
        
        $uri_explode = explode('/', $uri);
        $uri_array_length = count($uri_explode);
        
        $typeCat = $uri_explode[1]; // =cat ou evenements
        
        if ('cat' == $typeCat && 5 == $uri_array_length){
            $category = $em->getRepository('ShakyamouniMenuBundle:Category')->findOneBySlug($uri_explode[2]);
            $firstVisibleSubCat = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->getVisibleFirstSubCategoryByCategory($uri_explode[2]);
            $subCat = $em->getRepository('ShakyamouniMenuBundle:SubCategory')->findOneBySlug($uri_explode[4]);
        }
        elseif ('evenements' == $typeCat && 3 == $uri_array_length){
            $category = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findOneBySlug($uri_explode[2]);
            $firstVisibleSubCat = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->getVisibleFirstSubCategoryEvent($uri_explode[2]);
            $subCat = $em->getRepository('ShakyamouniMenuBundle:SubCategoryEvent')->findOneBySlug($uri_explode[2]);
        }
        elseif('cat' == $typeCat && 3 == $uri_array_length){ // calendrier
            $category = $em->getRepository('ShakyamouniMenuBundle:Category')->findOneBySlug($uri_explode[2]);
            $firstVisibleSubCat =  null;
            $subCat = null;
        }
        
        return $this->container->get('templating')
                ->renderResponse('ShakyamouniMenuBundle:BreadCrumbs:index.html.twig', 
                        array(
                            'uri_array_length' => $uri_array_length,
                            'typeCat' => $typeCat,
                            'category' => $category, 
                            'firstVisibleSubCat' => $firstVisibleSubCat[0],
                            'subCat' => $subCat,
                            )
                        );
    }

}
