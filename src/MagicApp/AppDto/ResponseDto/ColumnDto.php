<?php

namespace MagicApp\AppDto\ResponseDto;

class ColumnDto
{
    /**
     * The name of the field.
     *
     * @var string
     */
    public $field;

    /**
     * The value associated with the field.
     *
     * @var mixed
     */
    public $value;

    /**
     * The type of the field.
     *
     * @var string
     */
    public $type;

    /**
     * The label for the field.
     *
     * @var string
     */
    public $label;

    /**
     * Indicates whether the field is read-only.
     *
     * @var bool
     */
    public $readonly;

    /**
     * Indicates whether the field is hidden.
     *
     * @var bool
     */
    public $hidden;

    /**
     * The draft value associated with the field.
     *
     * @var mixed
     */
    public $valueDraft;

    /**
     * Constructor to initialize properties of the ColumnDto class.
     *
     * @param string $field The name of the field.
     * @param mixed $value The value associated with the field.
     * @param string $type The type of the field.
     * @param string $label The label for the field.
     * @param bool $readonly Indicates if the field is read-only.
     * @param bool $hidden Indicates if the field is hidden.
     * @param mixed $valueDraft The draft value associated with the field.
     */
    public function __construct($field, $value, $type, $label, $readonly, $hidden, $valueDraft)
    {
        $this->field = $field;
        $this->value = $value;
        $this->type = $type;
        $this->label = $label;
        $this->readonly = $readonly;
        $this->hidden = $hidden;
        $this->valueDraft = $valueDraft;
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
     * Set the name of the field and return the current instance for method chaining.
     *
     * @param string $field The name of the field.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get the value associated with the field.
     *
     * @return mixed The value associated with the field.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value associated with the field and return the current instance for method chaining.
     *
     * @param mixed $value The value to associate with the field.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get the type of the field.
     *
     * @return string The type of the field.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of the field and return the current instance for method chaining.
     *
     * @param string $type The type to set for the field.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get the label for the field.
     *
     * @return string The label for the field.
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the label for the field and return the current instance for method chaining.
     *
     * @param string $label The label to set for the field.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Check if the field is read-only.
     *
     * @return bool True if the field is read-only, otherwise false.
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * Set the read-only status of the field and return the current instance for method chaining.
     *
     * @param bool $readonly Indicates if the field should be read-only.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setReadonly($readonly)
    {
        $this->readonly = $readonly;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Check if the field is hidden.
     *
     * @return bool True if the field is hidden, otherwise false.
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the hidden status of the field and return the current instance for method chaining.
     *
     * @param bool $hidden Indicates if the field should be hidden.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get the draft value associated with the field.
     *
     * @return mixed The draft value associated with the field.
     */
    public function getValueDraft()
    {
        return $this->valueDraft;
    }

    /**
     * Set the draft value associated with the field and return the current instance for method chaining.
     *
     * @param mixed $valueDraft The draft value to associate with the field.
     * @return ColumnDto The current instance for method chaining.
     */
    public function setValueDraft($valueDraft)
    {
        $this->valueDraft = $valueDraft;
        return $this; // Return current instance for method chaining.
    }
}
