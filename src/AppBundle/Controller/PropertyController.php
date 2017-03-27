<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostfixInstance;
use AppBundle\Entity\Property;
use AppBundle\Form\PostfixInstanceType;
use AppBundle\Form\PropertyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * @Route("/admin")
 */
class PropertyController extends Controller
{

    /**
     * @Route("/property/add/{postfix}", name="property_add", requirements={"postfix": "\d+"})
     */
    public function addAction(Request $request, PostfixInstance $postfix)
    {
        $property = new Property();
        $property->setPostfixInstances($postfix);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isValid()) {
//            $postfixInstance->createFolderStructure();
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            return $this->redirect($this->generateUrl('property_add'));
        }
        return $this->render('property/add.html.twig', array('form' => $form->createView()));
    }

}
