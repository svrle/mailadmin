<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Domain;
use AppBundle\Form\DomainType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DomainController extends Controller
{
    /**
     * @Route("/domain", name="domain_homepage")
     */
    public function indexAction(Request $request)
    {
        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $domainRepo, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('knp_per_page')/*limit per page*/
        );
        return $this->render('domain/index.html.twig', ['domains' => $pagination]);
    }

    /**
     * @Route("/domain/new", name="domain_new")
     */
    public function newAction(Request $request)
    {
        $domain = new Domain();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($domain);
            $em->flush();
            return $this->redirect($this->generateUrl('domain_homepage'));
        }
        return $this->render('domain/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/domain/edit/{domain}", name="domain_edit", requirements={"domain": "\d+"})
     */
    public function editAction(Request $request, Domain $domain)
    {
        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->find($domain);
        if(!$domainRepo)
        {
            throw $this->createNotFoundException(
                'Wrong domain name'
            );
        }
        $form = $this->createForm(DomainType::class, $domainRepo);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($domainRepo);
            $em->flush();
            return $this->redirect($this->generateUrl('domain_homepage'));
        }
        return $this->render('domain/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/domain/remove/{domain}", name="domain_remove", requirements={"domain": "\d+"})
     */
    public function removeAction(Request $request, Domain $domain)
    {
        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->find($domain);

        if(!$domainRepo)
        {
            throw $this->createNotFoundException(
                'Wrong domain name'
            );
        }

        if($domainRepo->getEmailCount() == 0)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($domainRepo);
            $em->flush();
        }else {
            throw $this->createNotFoundException(
                'This '. $domain . ' have ' . $domain->getEmailCount() . ' emails'
            );
        }

        return $this->redirectToRoute('domain_homepage');
    }

}
