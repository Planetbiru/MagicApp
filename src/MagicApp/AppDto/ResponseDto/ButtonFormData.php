<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class ButtonFormData
 * 
 * A Data Transfer Object (DTO) representing data for a button form element. 
 * This includes typical HTML button attributes, such as `id`, `class`, and `value`.
 *
 * @package MagicApp\AppDto\ResponseDto
 * @author Kamshory
 * @link https://github.com/Planetbiru/MagicApp
 */
class ButtonFormData extends ToString
{
    /**
     * The type of the form element (e.g., 'button', 'input').
     *
     * @var string
     */
    public $element;

    /**
     * The CSS class applied to the button element.
     *
     * @var string
     */
    public $class;

    /**
     * The unique identifier for the button.
     *
     * @var string
     */
    public $id;

    /**
     * The name of the button, typically used in form submission.
     *
     * @var string
     */
    public $name;

    /**
     * The value of the button, typically used in form submission.
     *
     * @var string
     */
    public $value;

    /**
     * An associative array of additional attributes for the button element.
     *
     * @var array
     */
    public $attribute;

    /**
     * The text content inside the button element.
     *
     * @var string
     */
    public $textContent;

    /**
     * ButtonFormData constructor.
     *
     * This constructor allows initializing the properties of the ButtonFormData object.
     * All properties can be optionally initialized by passing values for each one. 
     * Default values are provided for each parameter in case no arguments are passed.
     *
     * @param string $element      The type of the button form element (default is 'button').
     * @param string $class        The CSS class applied to the button element (default is null).
     * @param string $id           The unique identifier for the button element (default is null).
     * @param string $name         The name attribute of the button (default is null).
     * @param string $value        The value attribute of the button (default is null).
     * @param array  $attribute    An associative array of additional attributes for the button (default is an empty array).
     * @param string $textContent  The text content inside the button element (default is null).
     */
    public function __construct(
        $element = 'button',
        $class = null,
        $id = null,
        $name = null,
        $value = null,
        $attribute = array(),
        $textContent = null
    ) {
        $this->element = $element;
        $this->class = $class;
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->attribute = $attribute;
        $this->textContent = $textContent;
    }

    /**
     * Get the element type.
     *
     * @return string The type of the form element.
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Set the element type.
     *
     * @param string $element The element type (e.g., 'button', 'input').
     * @return self The current instance for method chaining.
     */
    public function setElement($element)
    {
        $this->element = $element;
        return $this;
    }

    /**
     * Get the CSS class applied to the button.
     *
     * @return string The CSS class.
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the CSS class for the button.
     *
     * @param string $class The CSS class to apply to the button.
     * @return self The current instance for method chaining.
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Get the ID of the button.
     *
     * @return string The unique ID of the button.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the ID of the button.
     *
     * @param string $id The unique identifier for the button.
     * @return self The current instance for method chaining.
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the name of the button.
     *
     * @return string The name attribute of the button.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the button.
     *
     * @param string $name The name of the button.
     * @return self The current instance for method chaining.
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of the button.
     *
     * @return string The value attribute of the button.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the button.
     *
     * @param string $value The value to set for the button.
     * @return self The current instance for method chaining.
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the additional attributes for the button.
     *
     * @return array The associative array of additional attributes.
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set the additional attributes for the button.
     *
     * @param array $attribute The associative array of attributes to set for the button.
     * @return self The current instance for method chaining.
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * Add a new attribute to the button.
     * If the attribute key already exists, the value will be updated.
     *
     * @param string $key   The attribute key (e.g., 'data-toggle')
     * @param string $value The attribute value (e.g., 'modal')
     * @return self The current instance for method chaining.
     */
    public function appendAttribute($key, $value)
    {
        $this->attribute[$key] = $value;
        return $this;
    }

    /**
     * Get the text content of the button.
     *
     * @return string The text content inside the button element.
     */
    public function getTextContent()
    {
        return $this->textContent;
    }

    /**
     * Set the text content of the button.
     *
     * @param string $textContent The text content inside the button element.
     * @return self The current instance for method chaining.
     */
    public function setTextContent($textContent)
    {
        $this->textContent = $textContent;
        return $this;
    }
}
