<?php

namespace MagicApp;

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
                $selected = ' seledted';
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