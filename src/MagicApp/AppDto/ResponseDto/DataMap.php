<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class DataMap
 *
 * Represents a mapping of fields to their corresponding values or definitions.
 * This class contains a field name and an associative array that defines how 
 * the field is mapped, allowing for flexible data transformation and retrieval.
 */
class DataMap
{
    /**
     * The name of the field being mapped.
     *
     * @var string
     */
    public $field;
    
    /**
     * An associative array representing the mapping of the field.
     *
     * @var array
     */
    public $map;

    /**
     * Constructor for initializing a DataMap instance.
     *
     * @param string $field The name of the field.
     * @param array $map An associative array defining the mapping for the field.
     */
    public function __construct($field, $map)
    {
        $this->field = $field;
        $this->map = $map;
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
     * Get the mapping for the field.
     *
     * @return array The mapping for the field.
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set the mapping for the field.
     *
     * @param array $map The mapping for the field.
     * @return self The instance of this class.
     */
    public function setMap($map)
    {
        $this->map = $map;
        return $this;
    }
}
