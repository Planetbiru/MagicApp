<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) for displaying record in a table format.
 */
class DetailDto extends ResponseDto
{
    /**
     * The main data structure containing the list of items.
     *
     * @var DetailDataDto
     */
    public $data;

    /**
     * Get the main data structure containing the detail columns.
     *
     * @return DetailDataDto|null The detail data structure.
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add a new detail column.
     *
     * This method creates a new DetailColumnDto and appends it to the detail data structure.
     *
     * @param string $field The field associated with the detail.
     * @param ValueDto $value The value associated with the detail.
     * @param string|null $label The label describing the detail.
     * @param bool $readonly Whether the detail is readonly.
     * @param bool $hidden Whether the detail is hidden.
     * @param ValueDto|null $valueDraft The value associated with the draft data.
     * @return self The instance of this class.
     */
    public function addData($field, $value, $type = null, $label = null, $readonly = false, $hidden = false, $valueDraft = null)
    {
        $this->data->appendData($field, $value, $type, $label, $readonly, $hidden, $valueDraft);
        return $this;
    }

    /**
     * Add a primary key name and its data type to the list of primary keys.
     *
     * This method initializes the primary key name and data type properties as arrays if they haven't been set,
     * then appends the new primary key name and its corresponding data type to the lists.
     *
     * @param string $primaryKeyName The primary key name to add.
     * @param string $primaryKeyDataType The primary key data type to add.
     * @return self The instance of this class.
     */
    public function addPrimaryKeyName($primaryKeyName, $primaryKeyDataType)
    {
        if (!isset($this->data->primaryKeyName)) {
            $this->data->primaryKeyName = []; // Initialize as an array if not set
            $this->primaryKeyDataType = []; // Initialize as an array if not set
        }   
        $this->data->primaryKeyName[] = $primaryKeyName; // Append the primary key name
        $this->data->primaryKeyDataType[$primaryKeyName] = $primaryKeyDataType; // Append the primary key data type
        return $this;
    }

    /**
     * Convert the ListDto instance to a JSON string representation.
     *
     * This method clones the current instance and encodes it into a JSON format.
     *
     * @return string JSON representation of the ListDto instance.
     */ 
    public function __toString()
    {
        return json_encode([
            'responseCode' => $this->responseCode,
            'responseMessage' => $this->responseMessage,
            'data' => $this->data,
        ], JSON_PRETTY_PRINT);
    }
}
