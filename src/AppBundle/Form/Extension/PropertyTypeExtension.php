<?php
namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Created by PhpStorm.
 * User: svrle
 * Date: 4/2/17
 * Time: 10:12 AM
 */
class PropertyTypeExtension extends AbstractTypeExtension
{

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        // TODO: Implement getExtendedType() method.
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('property_value', 'property_name', 'property_description'));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        //value
        if (isset($options['property_value'])) {
            $parentData = $form->getParent()->getData();

            $propertyValue = null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $propertyValue = $accessor->getValue($parentData, $options['property_value']);
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['property_value'] = $propertyValue;
        }
        //name
        if (isset($options['property_name'])) {
            $parentData = $form->getParent()->getData();

            $propertyName = null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $propertyName = $accessor->getValue($parentData, $options['property_name']);
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['property_name'] = $propertyName;
        }

        //description
        if (isset($options['property_description'])) {
            $parentData = $form->getParent()->getData();

            $propertyDescription = null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $propertyDescription = $accessor->getValue($parentData, $options['property_description']);
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['property_description'] = $propertyDescription;
        }
    }
}