<?php
namespace AppBundle\Form;

use Symfony\Component\Form\ChoiceList\LazyChoiceList;
use Symfony\Component\Yaml\Parser;

class DefaultChoice extends LazyChoiceList
{
    public function loadChoiceList ()
    {
        // read the Yaml file, $data will be an array
        $yaml = new Parser();
        $data = $yaml->parse(file_get_contents(__DIR__ . '/../Resources/config/postfix.yml'));

        // the keys of the array will be used as the option value
        // the values of the array will be used as the option text
        // ie: <option value="option-1">First Option</option>
        $choices = array(
            'option-1' => 'First Option',
            'option-2' => 'Second Option',
        );

        return new SimpleChoiceList($choices);
    }
}