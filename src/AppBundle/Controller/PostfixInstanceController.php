<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostfixInstance;
use AppBundle\Entity\Property;
use AppBundle\Form\PostfixInstanceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

/**
 * @Route("/admin")
 */
class PostfixInstanceController extends Controller
{
    /**
     * @Route("/postfix", name="postfix_homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $postfixRepo = $this->getDoctrine()->getRepository('AppBundle:PostfixInstance')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $postfixRepo, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('knp_per_page')/*limit per page*/
        );
        return $this->render('postfixInstance/index.html.twig', ['postfixes' => $pagination]);
    }

    /**
     * @Route("/postfix/new", name="postfix_new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $yaml = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/postfix.yml'));
        $postfixInstance = new PostfixInstance();
        foreach ($yaml['default'] as $key => $value) {
            $property = new Property();
            $property->setName($key);
            $property->setType($value['type']);
            $property->setValue($value['value']);
//            $property->getIsNew(true);

            $postfixInstance->addProperty($property);
        }

        $form = $this->createForm(PostfixInstanceType::class, $postfixInstance);
        $form->handleRequest($request);
        if ($form->isValid()) {
//            $postfixInstance->createFolderStructure();
            $em = $this->getDoctrine()->getManager();
            $em->persist($postfixInstance);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_homepage'));
        }
        return $this->render('postfixInstance/new.html.twig', array('form' => $form->createView()));
    }

}
