<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) representing input fields in a form.
 */
class InputDto
{
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
     * @var string[]
     */
    protected $inputOption;

    /**
     * Source endpoint for fetching options if control type is select and $inputOption is null or empty.
     *
     * @var string|null
     */
    protected $sourceEndpoint;

    /**
     * Constructor for initializing an InputDto instance.
     *
     * @param string $field The name of the field.
     * @param string $label The data label of the input.
     * @param string $type The data type of the input.
     * @param string $controlType The control type for the input.
     * @param string[] $inputOption An array of options for the input.
     * @param string|null $sourceEndpoint The source endpoint for options if needed.
     */
    public function __construct($field, $label, $type, $controlType, $inputOption = [], $sourceEndpoint = null)
    {
        $this->field = $field;
        $this->label = $label;
        $this->type = $type;
        $this->controlType = $controlType;
        $this->inputOption = $inputOption;
        $this->sourceEndpoint = $sourceEndpoint;
    }

    /**
     * Get the name of the field.
     *
     * @return string The name of the field.
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the name of the field.
     *
     * @param string $field The name of the field.
     * @return self The instance of this class.
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
    
    /**
     * Get the data label of the input.
     *
     * @return string The data label of the input.
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the data label of the input.
     *
     * @param string $label The data label of the input.
     * @return self The instance of this class.
     */ 
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the data type of the input.
     *
     * @return string The data type of the input.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the data type of the input.
     *
     * @param string $type The data type of the input.
     * @return self The instance of this class.
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the control type of the input.
     *
     * @return string The control type of the input.
     */
    public function getControlType()
    {
        return $this->controlType;
    }

    /**
     * Set the control type of the input.
     *
     * @param string $controlType The control type of the input.
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
     * @return string[] An array of options for the input.
     */
    public function getInputOption()
    {
        return $this->inputOption;
    }

    /**
     * Set the options for the input.
     *
     * @param string[] $inputOption An array of options for the input.
     * @return self The instance of this class.
     */
    public function setInputOption($inputOption)
    {
        $this->inputOption = $inputOption;
        return $this;
    }

    /**
     * Get the source endpoint for options.
     *
     * @return string|null The source endpoint for options if applicable.
     */
    public function getSourceEndpoint()
    {
        return $this->sourceEndpoint;
    }

    /**
     * Set the source endpoint for options.
     *
     * @param string|null $sourceEndpoint The source endpoint for options.
     * @return self The instance of this class.
     */
    public function setSourceEndpoint($sourceEndpoint)
    {
        $this->sourceEndpoint = $sourceEndpoint;
        return $this;
    }
}
