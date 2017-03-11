<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Domain;
use AppBundle\Entity\Email;
use AppBundle\Form\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends Controller
{
    /**
     * @Route("/email", name="email_homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/email/new/{domain}", name="email_new", requirements={"domain": "\d+"})
     */
    public function newAction(Request $request, Domain $domain)
    {
        $email = new Email();
        $email->setDomain($domain);
//        $domain->setEmails($email); // ?
        $form = $this->createForm(EmailType::class, $email);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
            return $this->redirect($this->generateUrl('email_homepage'));
        }
        return $this->render('email/new.html.twig', array('form' => $form->createView(), 'entity' => $email));

    }

    /**
     * @Route("/email/list/{domain}", name="email_list", requirements={"domain": "\d+"})
     */
    public function listAction(Request $request, Domain $domain)
    {
        $emailRepo = $this->getDoctrine()->getRepository('AppBundle:Email')->findBy(array('domain' => $domain));

        return $this->render('email/list.html.twig', ['emails' => $emailRepo]);
    }
}
