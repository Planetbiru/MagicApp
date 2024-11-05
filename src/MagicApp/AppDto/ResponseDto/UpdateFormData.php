<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class UpdateFormData
 *
 * Represents the data structure for updating form filters or input fields in the UI.
 * This class defines the configuration for a form element that is intended to update
 * data in the backend. The class contains properties related to form inputs, including the columns
 * or input fields that are displayed in the form for the user to interact with.
 *
 * In this class, the `column` property holds an array of `InputFormData` objects, which represent
 * the individual fields in the update form.
 *
 * Properties:
 * - `column`: An array of `InputFormData` objects, each representing a column or input field in the form.
 *
 * @package MagicApp\AppDto\ResponseDto
 */
class UpdateFormData
{
    /**
     * The columns or input fields associated with the update form.
     * This property holds an array of `InputFormData` objects, each representing a column
     * or filter element for the form used in updating data.
     *
     * @var InputFormData[] Array of `InputFormData` objects.
     */
    public $column;

    /**
     * UpdateFormData constructor.
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
