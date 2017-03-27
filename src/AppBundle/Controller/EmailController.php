<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Domain;
use AppBundle\Entity\Email;
use AppBundle\Form\AliasType;
use AppBundle\Form\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class EmailController extends Controller
{
    /**
     * @Route("/email", name="email_homepage")
     */
    public function indexAction()
    {
        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->findAll();

        return $this->render('email/index.html.twig', ['domains' => $domainRepo]);
    }

    /**
     * @Route("/email/new/{domain}", name="email_new", requirements={"domain": "\d+"})
     * @param Request $request
     * @param Domain $domain
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, Domain $domain)
    {

        if($domain->isNumberOfEmailsValid() == false)
        {
            throw $this->createNotFoundException(
                "You reach maximum number of emails for $domain"
            );
        }
        $email = new Email();

        $email->setDomain($domain);
        $form = $this->createForm(EmailType::class, $email, array('email' => $email));
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
     * @param Domain $domain
     * @return Response
     */
    public function listAction(Domain $domain)
    {
        $emailRepo = $this->getDoctrine()->getRepository('AppBundle:Email')->findBy(array('domain' => $domain));

        return $this->render('email/list.html.twig', ['emails' => $emailRepo]);
    }

    /**
     * @Route("/email/edit/{email}", name="email_edit", requirements={"email": "\d+"})
     * @param Request $request
     * @param Email $email
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Email $email)
    {
        //ToDo when edit email, can`t assign existing alias from choice box. That can be assigned only from Alias -> Add email
        $emailRepo = $this->getDoctrine()->getRepository('AppBundle:Email')->find($email);
        if(!$emailRepo)
        {
            throw $this->createNotFoundException(
                'Wrong email name'
            );
        }
        $form = $this->createForm(EmailType::class, $emailRepo, array('email' => $email));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emailRepo);
            $em->flush();
            return $this->redirect($this->generateUrl('email_homepage'));
        }
        return $this->render('email/register.html.twig', array('form' => $form->createView(), 'email' => $email));

    }

    /**
     * @Route("/email/remove/{email}", name="email_remove", requirements={"email": "\d+"})
     * @param Email $email
     * @return RedirectResponse
     * @internal param Request $request
     */
    public function removeAction(Email $email)
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

    /**
     * @Route("/email/details/{email}", name="email_details", requirements={"email": "\d+"})
     * @param Request $request
     * @param Email $email
     */
    public function detailsAction(Request $request, Email $email)
    {
        //Stuff from dovecotadm, quota, lastlogin over imap
    }

    /**
     * @Route("/alias/new/{domain}", name="alias_new", requirements={"domain": "\d+"})
     * @param Request $request
     * @param Domain $domain
     * @return RedirectResponse|Response
     */
    public function newAliasAction(Request $request, Domain $domain)
    {
        if($domain->isNumberOfAliasValid() == false)
        {
            throw $this->createNotFoundException(
                "You reach maximum number of aliases for $domain"
            );
        }
        // alias forms with validation group 'alias'
        $alias = new Email();
        $alias->setDomain($domain);
        $form = $this->createForm(AliasType::class, $alias, array('domain' => $domain));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alias);
            $em->flush();
            return $this->redirect($this->generateUrl('alias_homepage'));
        }
        return $this->render('alias/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/alias/add/{email}", name="alias_add", requirements={"email": "\d+"})
     * @param Request $request
     * @param Email $email
     * @return RedirectResponse|Response
     */
    public function addAliasAction(Request $request, Email $email)
    {
        //email to specific alias
//        $alias->setDomain($domain);
        $form = $this->createForm(AliasType::class, $email, array('domain' => $email->getDomain()));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
            return $this->redirect($this->generateUrl('domain_homepage'));
        }
        return $this->render(':alias:new.html.twig', array('form' => $form->createView()));    }

    /**
     * @Route("/alias", name="alias_homepage")
     * @return Response
     * @internal param Request $request
     */
    public function indexAliasAction()
    {
        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->findAll();

        return $this->render('alias/index.html.twig', ['domains' => $domainRepo]);
    }

    /**
     * @Route("/email/register/{domain}", name="email_registration")
     * @param Request $request
     * @param Domain $domain
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request, Domain $domain)
    {
        // 1) build the form
        $email = new Email();

        $email->setDomain($domain);
        $form = $this->createForm(EmailType::class, $email, array('email' => $email));

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('app.sha512_crypt_encoder')
                ->encodePassword($email->getPlainPassword(), $email->getSalt());
            $email->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('email_homepage');
        }

        return $this->render(
            'email/register.html.twig',
            array('form' => $form->createView(), 'email' => $email)
        );
    }

}
