<?php

namespace Shakyamouni\MenuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Shakyamouni\MenuBundle\Entity\Category;
use Shakyamouni\MenuBundle\Form\CategoryType;
use Shakyamouni\SiteBundle\Entity\Enquiry;
use Shakyamouni\SiteBundle\Entity\Date;
use Shakyamouni\SiteBundle\Form\EnquiryType;
use \HTML2PDF;

/**
 * Category controller.
 *
 * @Route("/cat")
 */
class CategoryFrontController extends Controller {

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{slug}", name="category_show")
     * @Template("ShakyamouniMenuBundle:CategoryFront:show.html.twig")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $category_contact = $em->getRepository('ShakyamouniMenuBundle:Category')->getContactCategory();
        $category_calendar = $em->getRepository('ShakyamouniMenuBundle:Category')->getCalendarCategory();
        $category = $em->getRepository('ShakyamouniMenuBundle:Category')->findOneBySlug($slug);

        if (!$category) {
            if ('dev' == $this->get('kernel')->getEnvironment()) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            } else {
                $response = new Response();
                $response = $this->render('ShakyamouniSiteBundle:Errors:error.404.html.twig', array());
                $response->setStatusCode(404);
                return $response;
            }
        }

        if (!is_null($category_contact)) {
            if ($slug == $category_contact->getSlug()){
                $enquiry = new Enquiry();
                $form = $this->createForm(new EnquiryType(), $enquiry);

                $request = $this->getRequest();
                if ($request->getMethod() == 'POST') {
                    $form->handleRequest($request);

                    if ($form->isValid()) {
                        $postValues = $form->getData();
                        $to = $this->container->getParameter('contact_email');

                        if ('webmaster' == $postValues->getContact()){
                            $to = $this->container->getParameter('webmaster_email');
                        }

                        $params = array('enquiry' => $enquiry);
                        $locale = 'fr';
                        $message = $this->container->get('lexik_mailer.message_factory')->get('formulaire-contact', $to, $params, $locale);
                        $this->container->get('mailer')->send($message);

                        $this->get('session')->setFlash('notice', $this->get('translator')->trans('contact.message_sent'));

                        return $this->redirect($this->generateUrl('category_show', array('slug' => $category_contact->getSlug())));
                    }
                }
            }
        }

        $subCategories = $this->getDoctrine()
                ->getRepository('ShakyamouniMenuBundle:SubCategory')
                ->getSubCategoriesByCategory($category->getSlug());


        if ($subCategories) {
            $subCategory = $subCategories[0];
            return $this->redirect($this->generateUrl('subcategory_show', array('category_slug' => $slug, 'subcategory_slug' => $subCategory->getSlug())));
        } elseif (!is_null($category_contact)) {
            if ($slug == $category_contact->getSlug()) {
                return array(
                    'category' => $category,
                    'contactCategory' => $category_contact,
                    'form' => $form->createView()
                );
            }
        } elseif ($slug == $category_calendar->getSlug()) {
            $pm = $this->getDoctrine()
                ->getRepository('ShakyamouniAdminBundle:Calendar')
                ->getLastActiveCalendarUpdated();
            
         //   $date = new Date();
         //   $year = date('Y');
         //   $dates = current($date->getAll($year));

         //   $events = $this->getDoctrine()
         //           ->getRepository('ShakyamouniSiteBundle:Event')
         //           ->getAllEventsByYear($year);

            return array(
                'category' => $category,
                'pm' => $pm,
         //       'dates' => $dates,
         //       'date' => $date,
         //       'events' => $events,
         //       'year' => $year,
            );
        } else {
            return array(
                'category' => $category
            );
        }
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/calendar-pdf/{month}/{year}", name="calendar_pdf")
     * @Template("ShakyamouniMenuBundle:CategoryFront:calendarpdf.html.twig")
     */
    public function createCalendarPdfAction($month, $year)
    {
        $date = new Date();
        $dates = current($date->getMonthCalendar($year, $month));

        $content = $this->renderView('ShakyamouniMenuBundle:CategoryFront:calendarpdf.html.twig', array('current_year' => $year,
            'current_month' => $month,
            'dates' => $dates,
            'date' => $date,
            'year' => $year)
        );

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            $html2pdf->Output('calendrier-' . $month . '-' . $year . '.pdf');
            exit;
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

}

