<?php

namespace MagicApp\AppDto\MocroServices;

/**
 * Class InputFieldFilter
 *
 * Represents an input field used for filtering data in a form or list. 
 * This class extends `InputFieldInsert` and adds functionality for storing 
 * the current value of the input, which is typically sent by the user 
 * during a previous action, such as a search or filter operation.
 *
 * @package MagicApp\AppDto\MocroServices
 */
class InputFieldFilter extends InputFieldInsert
{
    /**
     * The current value of the input field, typically representing 
     * the user's input from a previous action, such as a search or filter operation.
     *
     * @var InputFieldValue
     */
    protected $currentValue;
    
    /**
     * Constructor for InputFieldFilter.
     * Initializes the input field properties with provided values.
     *
     * @param InputField $inputField Input field
     * @param string $inputType The type of the input field.
     * @param string $dataType The data type of the input field.
     * @param string|null $optionSource Optional source for options (e.g., for a select dropdown).
     * @param InputFieldOption[]|null $map Optional array of available options for the input field.
     * @param string|null $pattern Optional regular expression pattern for validation.
     */
    public function __construct(
        $inputField,
        $inputType,
        $dataType,
        $optionSource = null,
        $map = null,
        $pattern = null,
        $currentValue = null
    ) {
        parent::__construct($inputField, $inputType, $dataType, $optionSource, $map, $pattern);
        $this->setCurrentValue($currentValue);
    }
    
    /**
     * Get the current value of the input field.
     *
     * @return InputFieldValue The current value of the input field.
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * Set the current value of the input field.
     *
     * @param InputFieldValue $currentValue The current value to set for the input field.
     * 
     * @return self Returns the current instance for method chaining.
     */
    public function setCurrentValue($currentValue)
    {
        $this->currentValue = $currentValue;

        return $this;
    }
}
