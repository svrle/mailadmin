<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/admin")
 */
class PostfixInstanceController extends Controller
{
    /**
     * @Route("/postfix", name="postfix_homepage")
     */
    public function indexAction(Request $request)
    {
//        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->findAll();
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $domainRepo, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            $this->getParameter('knp_per_page')/*limit per page*/
//        );
//        return $this->render('domain/index.html.twig', ['domains' => $pagination]);
    }

}
