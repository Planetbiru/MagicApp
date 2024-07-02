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
    
    /**
     * return selected="selected" if $param1 == $param2 
     *
     * @param mixed $param1 Parameter 1
     * @param mixed $param2 Parameter 2
     * @return string
     */
    public static function selected($param1, $param2)
    {
        return $param1 == $param2 ? ' selected="selected"' : '';
    }
    
    /**
     * return checked="checked" if $param1 == $param2 
     *
     * @param mixed $param1 Parameter 1
     * @param mixed $param2 Parameter 2
     * @return string
     */
    public static function checked($param1, $param2)
    {
        return $param1 == $param2 ? ' checked="checked"' : '';
    }
    
    /**
     * Add class compare data
     *
     * @param boolean $div
     * @return string
     */
    public static function classCompareData($div)
    {
        return $div ? 'compare-data data-different':'compare-data';
    }
}