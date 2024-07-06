<?php

namespace MagicApp;

class AppFormSelect
{
    /**
     * Options
     *
     * @var AppFormOption[]
     */
    private $options = array();

    /**
     * Add option
     *
     * @param string $textNode
     * @param string $value
     * @param boolean $selected
     * @param string[] $attributes
     * @return self
     */
    public function add($textNode, $value = null, $selected = false, $attributes = null)
    {
        $this->options[] = new AppFormOption($textNode, $value, $selected, $attributes);
        return $this;
    }

    public function __tostring()
    {
        $opt = array();
        foreach($this->options as $option)
        {
            $opt[] = $option->toString();
        }
        return implode("\r\n", $opt);
    }
}