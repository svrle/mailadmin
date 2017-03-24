<?php

namespace AppBundle\Controller;

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
//        $domainRepo = $this->getDoctrine()->getRepository('AppBundle:Domain')->findAll();
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $domainRepo, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            $this->getParameter('knp_per_page')/*limit per page*/
//        );
//        return $this->render('domain/index.html.twig', ['domains' => $pagination]);
    }

    /**
     * @Route("/postfix/new", name="postfix_new")
     */
    public function newAction(Request $request)
    {
        $process = new Process('ls -lsa');
        $process->start();

        array_filter( explode("\n", $process->getOutput()), 'strlen');


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
