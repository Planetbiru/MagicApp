<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class ListFilter
 *
 * This class represents a filter for a list of items, allowing for
 * the specification of filtering criteria based on fields within the
 * data structure. Each filter includes the field name, data type,
 * label, control type, available options, and a source endpoint for
 * dynamic options retrieval. This is useful for creating dynamic 
 * forms and filters in user interfaces.
 */
class ListFilter
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
     * @var array
     */
    protected $attributes;
    
    /**
     * The name of the field.
     *
     * @var string
     */
    protected $field;

    /**
     * The data type of the input.
     *
     * @var string
     */
    protected $type;

    /**
     * The data label of the input.
     *
     * @var string
     */
    protected $label;

    /**
     * The control type (e.g., input[type="text"], input[type="number"], select, textarea, input[type="checkbox"], input[type="radio"]).
     *
     * @var string
     */
    protected $controlType;

    /**
     * An array of options for the input (e.g., for select controls).
     *
     * @var array
     */
    protected $inputOption;

    /**
     * Source endpoint for fetching options if control type is select and $inputOption is null or empty.
     *
     * @var string|null
     */
    protected $sourceEndpoint;

    /**
     * Constructor for initializing a ListFilter instance.
     *
     * @param string $tag The HTML tag for the control.
     * @param array $attributes An array of attributes for the control.
     * @param string $field The name of the field.
     * @param string $label The data label of the input.
     * @param string $type The data type of the input.
     * @param array $inputOption An array of options for the input.
     * @param string|null $sourceEndpoint The source endpoint for options if needed.
     */
    public function __construct($tag, $attributes, $field, $label, $type, $inputOption = array(), $sourceEndpoint = null)
    {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->field = $field;
        $this->label = $label;
        $this->type = $type;
        $this->inputOption = $inputOption;
        $this->sourceEndpoint = $sourceEndpoint;
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
     * Get the attributes for the control.
     *
     * @return array The attributes.
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes for the control.
     *
     * @param array $attributes The attributes.
     * @return self The instance of this class.
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get the name of the field.
     *
     * @return string The field name.
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the name of the field.
     *
     * @param string $field The field name.
     * @return self The instance of this class.
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Get the data type of the input.
     *
     * @return string The data type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the data type of the input.
     *
     * @param string $type The data type.
     * @return self The instance of this class.
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the data label of the input.
     *
     * @return string The data label.
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the data label of the input.
     *
     * @param string $label The data label.
     * @return self The instance of this class.
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the control type of the input.
     *
     * @return string The control type.
     */
    public function getControlType()
    {
        return $this->controlType;
    }

    /**
     * Set the control type of the input.
     *
     * @param string $controlType The control type.
     * @return self The instance of this class.
     */
    public function setControlType($controlType)
    {
        $this->controlType = $controlType;
        return $this;
    }

    /**
     * Get the options for the input.
     *
     * @return array An array of options.
     */
    public function getInputOption()
    {
        return $this->inputOption;
    }

    /**
     * Set the options for the input.
     *
     * @param array $inputOption An array of options.
     * @return self The instance of this class.
     */
    public function setInputOption($inputOption)
    {
        $this->inputOption = $inputOption;
        return $this;
    }

    /**
     * Get the source endpoint for fetching options.
     *
     * @return string|null The source endpoint.
     */
    public function getSourceEndpoint()
    {
        return $this->sourceEndpoint;
    }

    /**
     * Set the source endpoint for fetching options.
     *
     * @param string|null $sourceEndpoint The source endpoint.
     * @return self The instance of this class.
     */
    public function setSourceEndpoint($sourceEndpoint)
    {
        $this->sourceEndpoint = $sourceEndpoint;
        return $this;
    }
}
