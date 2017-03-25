<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostfixInstance;
use AppBundle\Form\PostfixInstanceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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
     */
    public function newAction(Request $request)
    {

        $postfixInstance = new PostfixInstance();
        $form = $this->createForm(PostfixInstanceType::class, $postfixInstance);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postfixInstance);
            $em->flush();
            $postfixInstance->createFolderStructure();
            return $this->redirect($this->generateUrl('postfix_homepage'));
        }
        return $this->render('postfixInstance/new.html.twig', array('form' => $form->createView()));
//        $process = new Process('ls -lsa');
//        $process->start();
//        array_filter( explode("\n", $process->getOutput()), 'strlen');


//        foreach ($process as $type => $data) {
//            if ($process::OUT === $type) {
////                echo "\nRead from stdout: ".$data;
//
//            } else { // $process::ERR === $type
//                echo "\nRead from stderr: ".$data;
//            }
//        }
    }

}
