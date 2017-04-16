<?php
namespace AppBundle\Controller;

use AppBundle\Entity\PostfixInstance;
use AppBundle\Entity\Property;
use AppBundle\Entity\Service;
use AppBundle\Form\PropertyType;
use AppBundle\Form\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $property->addPostfixInstance($postfix);
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

    /**
     * @param Request $request
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/property/edit/{property}", name="property_edit", requirements={"property": "\d+"})
     */
    public function editAction(Request $request, Property $property)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_new_service', array('postfix' => $property->getPostfixInstances()->getId())));
        }
        return $this->render('property/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/service/property/new/{service}", name="service_property_new", requirements={"service": "\d+"})
     */
    public function newServicePropertyAction(Request $request, Service $service)
    {
        $property = new Property();
        $property->setService($service);
//        $property->setType('string');
        $property->setIsNew(true);
        $form = $this->createForm(PropertyType::class, $property, array('property' => $property));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            return $this->redirect($this->generateUrl('postfix_new_service', array('postfix' => $service->getPostfixInstance()->getId())));
        }
        return $this->render('property/new.html.twig', array('form' => $form->createView(), 'service' => $service));

    }

}
