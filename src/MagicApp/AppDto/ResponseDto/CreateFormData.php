<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class CreateFormData
 *
 * Represents a data structure for creating form filters or input elements in the UI.
 * This class handles the configuration for a filter or form input, such as the filter's label, field name, 
 * input type, default value, and other attributes.
 *
 * In this version, the class has a `column` property, which is an array of `InputFormData` objects.
 * Each `InputFormData` represents a column within a form, such as a filter or search field.
 *
 * Properties:
 * - `column`: An array of `InputFormData` objects, each representing a column or input field in the form.
 *
 * @package MagicApp\AppDto\ResponseDto
 */
class CreateFormData
{
    /**
     * The columns or input fields associated with the form.
     * This property holds an array of `InputFormData` objects, each representing a column or filter element.
     *
     * @var InputFormData[] Array of `InputFormData` objects.
     */
    public $column;

    /**
     * CreateFormData constructor.
     *
     * Initializes the `column` property as an empty array.
     */
    public function __construct()
    {
        $this->column = [];
    }

    /**
     * Gets the array of `InputFormData` objects representing the columns or input fields.
     *
     * @return InputFormData[] The array of `InputFormData` objects.
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Sets the array of `InputFormData` objects representing the columns or input fields.
     * 
     * @param InputFormData[] $column The array of `InputFormData` objects to set.
     * @return self Returns the current instance for method chaining.
     */
    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * Adds a single `InputFormData` object to the `column` array.
     *
     * @param InputFormData $inputFormData The `InputFormData` object to add.
     * @return self Returns the current instance for method chaining.
     */
    public function addColumn($inputFormData)
    {
        $this->column[] = $inputFormData;
        return $this;
    }
}
