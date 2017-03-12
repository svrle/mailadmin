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
        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->findAll();

        return $this->render('email/index.html.twig', ['domains' => $domainRepo]);
    }

    /**
     * @Route("/email/new/{domain}", name="email_new", requirements={"domain": "\d+"})
     */
    public function newAction(Request $request, Domain $domain)
    {
        $email = new Email();
        $email->setDomain($domain);
        $form = $this->createForm(EmailType::class, $email);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $plaintext = $email->getPassword();
            $email->setPassword(hash('sha512', $plaintext));
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

    /**
     * @Route("/email/edit/{email}", name="email_edit", requirements={"email": "\d+"})
     */
    public function editAction(Request $request, Email $email)
    {
        $emailRepo = $this->getDoctrine()->getRepository('AppBundle:Email')->find($email);
        if(!$emailRepo)
        {
            throw $this->createNotFoundException(
                'Wrong email name'
            );
        }
        $form = $this->createForm(EmailType::class, $emailRepo);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emailRepo);
            $em->flush();
            return $this->redirect($this->generateUrl('email_homepage'));
        }
        return $this->render('email/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/email/remove/{email}", name="email_remove", requirements={"email": "\d+"})
     */
    public function removeAction(Request $request, Email $email)
    {
        $emailRepo = $this->getDoctrine()->getRepository('AppBundle:Email')->find($email);

        if(!$emailRepo)
        {
            throw $this->createNotFoundException(
                'Wrong email name'
            );
        }else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emailRepo);
            $em->flush();
        }

        return $this->redirectToRoute('email_homepage');
    }
}
