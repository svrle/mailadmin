<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostfixInstance;
use AppBundle\Entity\Property;
use AppBundle\Entity\Service;
use AppBundle\Form\ConfigType;
use AppBundle\Form\ConfigTypeT;
use AppBundle\Form\PostfixInstanceType;
use AppBundle\Form\PropertyType;
use AppBundle\Form\ServiceType;
use AppBundle\Process\PostfixProcess;
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
     * @param PostfixInstance $postfix
     * @return Response
     * @Route("/postfix/{postfix}", name="postfix_details", requirements={"postfix": "\d+"})
     */
    public function detailsAction(PostfixInstance $postfix)
    {
        return $this->render('postfixInstance/details.html.twig', ['postfix' => $postfix]);
    }

    /**
     * @Route("/postfix/new", name="postfix_new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        //Index
        $postfixRepo = $this->getDoctrine()->getRepository('AppBundle:PostfixInstance')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $postfixRepo, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('knp_per_page')/*limit per page*/
        );

        $yaml = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/postfix.yml'));
        $postfixInstance = new PostfixInstance();

        if(count($postfixRepo) >= 10) {
            $postfixInstance->setIsSingleInstance(true);
        }
        foreach ($yaml['main'] as $key => $value) {
            $property = new Property();
            $property->setName($key);
            $property->setType($value['type']);
            $property->setValue($value['value']);
            $property->setDescription($value['description']);
            $property->setIsNew(true);

            $postfixInstance->addProperty($property);
        }

        $form = $this->createForm(PostfixInstanceType::class, $postfixInstance);
        $form->handleRequest($request);
        if ($form->isValid()) {
//            $postfixInstance->createFolderStructure();
            $em = $this->getDoctrine()->getManager();
            $em->persist($postfixInstance);
            $em->flush();
//            new PostfixProcess($postfixInstance);
            return $this->redirect($this->generateUrl('postfix_homepage'));
        }
        return $this->render('postfixInstance/new.html.twig', array('form' => $form->createView(), 'postfixes' => $pagination));
    }

    /**
     * @param Request $request
     * @param PostfixInstance $postfixInstance
     * @return RedirectResponse|Response
     * @Route("/postfix/edit/{postfixInstance}", name="postfix_edit", requirements={"postfixInstance": "\d+"})
     */
    public function editAction(Request $request, PostfixInstance $postfixInstance)
    {
        $yaml = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/postfix.yml'));
        foreach ($postfixInstance->getProperties() as $property) {
            $property->populateDescriptionFromYaml($yaml);
        }

        $form = $this->createForm(PostfixInstanceType::class, $postfixInstance);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postfixInstance);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_homepage'));
        }

        return $this->render('postfixInstance/edit.html.twig', array('form' => $form->createView(), 'postfix' => $postfixInstance));
    }

    /**
     * @param Request $request
     * @param PostfixInstance $postfix
     * @return RedirectResponse|Response
     * @Route("/postfix/service/new/{postfix}", name="postfix_new_service", requirements={"postfix": "\d+"})
     */
    public function newServiceAction(Request $request, PostfixInstance $postfix)
    {
        $service = new Service();
        $service->setPostfixInstance($postfix);

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_edit_service', array('postfix' => $postfix->getId())));
        }
        return $this->render('postfixInstance/newService.html.twig', array('form' => $form->createView(), 'postfix' => $postfix));
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return RedirectResponse|Response
     * @Route("/postfix/service/edit/{service}", name="postfix_edit_service", requirements={"postfix": "\d+"})
     */
    public function editServiceAction(Request $request, Service $service)
    {
//        $yaml = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/postfix.yml'));
//        foreach ($yaml['master'] as $key => $value) {
//            $property = new Property();
//            $property->setName($key);
//            $property->setType($value['type']);
//            $property->setValue($value['value']);
//            $property->setDescription($value['description']);
//            $property->setIsNew(true);
//
//            $service->addProperty($property);
//        }

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_new_service', array('postfix' => $service->getPostfixInstance()->getId())));
        }
        return $this->render('postfixInstance/editService.html.twig', array('form' => $form->createView(), 'service' => $service));
    }

    /**
     * @param Request $request
     * @param PostfixInstance $postfix
     * @return RedirectResponse|Response
     * @Route("/postfix/configuration/edit/{postfix}", name="postfix_edit_configuration", requirements={"postfix": "\d+"})
     */
    public function editConfigAction(Request $request, PostfixInstance $postfix)
    {
        $form = $this->createForm(ConfigType::class, $postfix);
        $form->handleRequest($request);
        if ($form->isValid()) {
//            $postfixInstance->createFolderStructure();
            $em = $this->getDoctrine()->getManager();
            $em->persist($postfix);
            $em->flush();
//            new PostfixProcess($postfixInstance);
            return $this->redirect($this->generateUrl('postfix_details', array('postfix' => $postfix->getId())));
        }
        return $this->render('postfixInstance/editConfig.html.twig', array('form' => $form->createView()));
    }

}
