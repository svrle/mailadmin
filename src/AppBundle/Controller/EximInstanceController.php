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
        $yaml = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/exim.yml'));
        $exims = array();
        foreach ($yaml['default'] as $key => $value) {
            $eximInstance = new EximInstance();
            $exims[] = $eximInstance;
            $eximInstance->name = $key;
            $eximInstance->type = $value['type'];
            $eximInstance->value = $value['value'];
        }
        return $this->render('eximInstance/index.html.twig', ['exims' => $exims]);
    }

    /**
     * @Route("/exim/new", name="exim_new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $eximInstance = new EximInstance();

        $form = $this->createForm(EximInstanceType::class, $eximInstance);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $exim = array(
                $eximInstance->name => array(
                    'value' => $eximInstance->value,
                    'type' => $eximInstance->type
                )
            );

            return $this->redirect($this->generateUrl('exim_homepage'));
        }
        return $this->render('eximInstance/new.html.twig', array('form' => $form->createView()));
    }
}
