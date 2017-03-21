<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Encryption;
use AppBundle\Form\DomainType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class EncryptionController extends Controller
{
    /**
     * @Route("/encryption", name="encryption_homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @Route("/encryption/new", name="encryption_new")
     * @param Request $request
     */
    public function newAction(Request $request)
    {
//        $domain = new Domain();
//        $form = $this->createForm(DomainType::class, $domain);
//        $form->handleRequest($request);
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($domain);
//            $em->flush();
//            return $this->redirect($this->generateUrl('domain_homepage'));
//        }
//        return $this->render('domain/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/encryption/edit/{encryption}", name="encryption_edit", requirements={"encryption": "\d+"})
     * @param Request $request
     * @param Encryption $encryption
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Encryption $encryption)
    {
        $encryptionRepo = $this->getDoctrine()->getRepository('AppBundle:Encryption')->find($encryption);
        if(!$encryptionRepo)
        {
            throw $this->createNotFoundException(
                'Wrong domain name'
            );
        }
        $form = $this->createForm(DomainType::class, $encryptionRepo);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($encryptionRepo);
            $em->flush();
            return $this->redirect($this->generateUrl('encryption_homepage'));
        }
        return $this->render('domain/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/encryption/remove/{encryption}", name="encryption_remove", requirements={"encryption": "\d+"})
     * @param Encryption $encryption
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param Request $request
     */
    public function removeAction(Encryption $encryption)
    {
        $encryptionRepo = $this->getDoctrine()->getRepository('AppBundle:Encryption')->find($encryption);

        if(!$encryptionRepo)
        {
            throw $this->createNotFoundException(
                'Wrong encryption name'
            );
        }

//        if($encryptionRepo->getEmailCount() == 0)
//        {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($domainRepo);
//            $em->flush();
//        }else {
//            throw $this->createNotFoundException(
//                'This '. $domain . ' have ' . $domain->getEmailCount() . ' emails'
//            );
//        }

        return $this->redirectToRoute('encryption_homepage');
    }

}
