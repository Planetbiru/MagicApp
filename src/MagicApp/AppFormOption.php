<?php

namespace MagicApp;

use MagicObject\Util\PicoStringUtil;

class AppFormOption
{

    /**
     * Text node
     *
     * @var string
     */
    private $textNode;

    /**
     * Value
     *
     * @var string
     */
    private $value;

    /**
     * Selected
     *
     * @var boolean
     */
    private $selected;


    /**
     * Attributes
     *
     * @var string[]
     */
    private $attributes;

    public function __construct($textNode, $value = null, $selected = false, $attributes = null)
    {
        $this->textNode = $textNode;
        $this->value = $value;
        $this->selected = $selected;
        $this->attributes = $attributes;
    }

    /**
     * Create attributes
     *
     * @return string
     */
    public function createAttributes()
    {
        $attrs = array();
        if(isset($this->attributes) && is_array($this->attributes))
        {
            foreach($this->attributes as $attr=>$val)
            {
                $attrs[] = 'data-'.str_replace('_', '-', PicoStringUtil::snakeize($attr)).'="'.htmlspecialchars($val).'"';
            }
            return ' '.implode(' ', $attrs);
        }
        return '';
    }

    public function __tostring()
    {
        $selected = $this->selected ? ' seledted' : '';
        $attrs = $this->createAttributes();
        return '<option value="'.htmlspecialchars($this->value).'"'.$attrs.$selected.'>'.htmlspecialchars($this->textNode).'</option>';
    }

    /**
     * Alias toString
     *
     * @return string
     */
    public function toString()
    {
        return $this->__tostring();
    }
}