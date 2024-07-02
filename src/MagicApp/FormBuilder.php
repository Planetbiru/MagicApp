<?php

namespace MagicApp;

use MagicObject\Database\PicoSortable;
use MagicObject\Database\PicoSpecification;

class FormBuilder
{
    /**
     * Get instance of the class
     *
     * @return self
     */
    public static function getInstance()
    {
        return new self();
    }

    /**
     * Create select option
     *
     * @param MagicObject $entity
     * @param PicoSpecification $specification
     * @param PicoSortable $sortable
     * @param string $primaryKey
     * @param mixed $valueKey
     * @param mixed $currentValue
     * @param array $additionalOutput
     * @return string
     */
    public function createSelectOption($entity, $specification, $sortable, $primaryKey, $valueKey, $currentValue = null, $additionalOutput = null)
    {
        $htmlArray = array();
        $data = $entity->findAll($specification, null, $sortable, true);
        $result = $data->getResult();
        foreach($result as $row)
        {
            $value = $row->get($primaryKey);
            $label = $row->get($valueKey);
            if(isset($currentValue) && $currentValue == $value)
            {
                $selected = ' selected';
            }
            else
            {
                $selected = '';
            }
            $htmlArray[] = '<option value="'.$value.'"'.$selected.'>'.$label.'</option>';
        }

        return implode("\r\n", $htmlArray);
    }
}