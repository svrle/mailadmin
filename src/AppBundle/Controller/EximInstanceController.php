<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Form\EximInstanceType;
use AppBundle\Form\PostfixInstanceType;
use AppBundle\Model\EximInstance;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

/**
 * @Route("/admin")
 */
class EximInstanceController extends Controller
{
    /**
     * @Route("/exim", name="exim_homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
//        $postfixRepo = $this->getDoctrine()->getRepository('AppBundle:PostfixInstance')->findAll();
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $postfixRepo, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            $this->getParameter('knp_per_page')/*limit per page*/
//        );
//        return $this->render('postfixInstance/index.html.twig', ['postfixes' => $pagination]);
    }

    /**
     * @Route("/exim/new", name="exim_new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $yaml = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/postfix.yml'));
        $eximInstance = new EximInstance();
        foreach ($yaml['default'] as $key => $value) {
//            $property = new Property();
//            $property->setName($key);
//            $property->setType($value['type']);
//            $property->setValue($value['value']);
////            $property->getIsNew(true);

//            $postfixInstance->addProperty($property);
        }

        $form = $this->createForm(EximInstanceType::class, $eximInstance);
        $form->handleRequest($request);
        if ($form->isValid()) {
//            $postfixInstance->createFolderStructure();
            $em = $this->getDoctrine()->getManager();
            $em->persist($eximInstance);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_homepage'));
        }
        return $this->render('postfixInstance/new.html.twig', array('form' => $form->createView()));
    }
}
