<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class ListDataControl
 *
 * This class represents a generic data control element, such as a button, input, or reset,
 * with associated attributes and content. It allows for flexible creation of various 
 * UI elements within a data structure.
 */
class ListDataControl
{
    /**
     * The HTML tag representing the control (e.g., 'button', 'input', 'reset').
     *
     * @var string
     */
    protected $tag;

    /**
     * An associative array of attributes for the control (e.g., ['type' => 'submit']).
     *
     * @var string[]
     */
    protected $attributes;

    /**
     * The content or label displayed within the control.
     *
     * @var string
     */
    protected $content;

    /**
     * Constructor for initializing a ListDataControl instance.
     *
     * @param string $tag The HTML tag for the control.
     * @param string[] $attributes An array of attributes for the control.
     * @param string $content The content or label for the control.
     */
    public function __construct($tag, $attributes = [], $content = '')
    {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->content = $content;
    }

    /**
     * Get the HTML tag representing the control.
     *
     * @return string The HTML tag.
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the HTML tag representing the control.
     *
     * @param string $tag The HTML tag.
     * @return self The instance of this class.
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Get the attributes of the control.
     *
     * @return string[] The attributes of the control.
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes of the control.
     *
     * @param string[] $attributes The attributes for the control.
     * @return self The instance of this class.
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get the content or label displayed within the control.
     *
     * @return string The content of the control.
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content or label displayed within the control.
     *
     * @param string $content The content for the control.
     * @return self The instance of this class.
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}
