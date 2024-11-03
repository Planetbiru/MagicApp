<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class DetailDataDto
 *
 * Represents the data structure for a table, including column titles and rows.
 * This class manages the titles of columns, a data map, and the rows of data 
 * represented as RowDto instances. It provides methods for appending 
 * titles, data maps, and rows, as well as resetting these structures.
 * 
 * The class extends the ToString base class, enabling string representation based on 
 * the specified property naming strategy.
 * 
 * @package MagicApp\AppDto\ResponseDto
 * @author Kamshory
 * @link https://github.com/Planetbiru/MagicApp
 */
class DetailDataDto extends ToString
{
    /**
     * The name of the primary key in the data structure.
     *
     * @var string[]|null
     */
    public $primaryKeyName;

    /**
     * An associative array mapping primary key names to their data types.
     *
     * @var string[]
     */
    public $primaryKeyDataType;

    /**
     * An array of columns, each represented as a ColumnDto.
     *
     * @var ColumnDto[]
     */
    public $columns;

    /**
     * Metadata associated with the row.
     *
     * @var MetadataDto
     */
    public $metadata;

    /**
     * Get the name of the primary key in the data structure.
     *
     * @return string[]|null The name of the primary key.
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

    /**
     * Set the name of the primary key in the data structure.
     *
     * @param string[]|null $primaryKeyName The name of the primary key.
     * @return self The current instance for method chaining.
     */
    public function setPrimaryKeyName($primaryKeyName)
    {
        $this->primaryKeyName = $primaryKeyName;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Add a primary key name and its data type to the list of primary keys.
     *
     * This method initializes the primary key name and data type properties as arrays if they haven't been set,
     * then appends the new primary key name and its corresponding data type to the lists.
     *
     * @param string $primaryKeyName The primary key name to add.
     * @param string $primaryKeyDataType The primary key data type to add.
     * @return self The instance of this class for method chaining.
     */
    public function addPrimaryKeyName($primaryKeyName, $primaryKeyDataType)
    {
        if (!isset($this->primaryKeyName)) {
            $this->primaryKeyName = array(); // Initialize as an array if not set
            $this->primaryKeyDataType = array(); // Initialize as an array if not set
        }
        $this->primaryKeyName[] = $primaryKeyName; // Append the primary key name
        $this->primaryKeyDataType[$primaryKeyName] = $primaryKeyDataType; // Append the primary key data type
        return $this; // Return current instance for method chaining.
    }

    /**
     * Append a row of data to the table.
     *
     * This method adds a new row to the internal columns collection using the provided
     * parameters to create a ColumnDto instance.
     *
     * @param string $field The name of the field.
     * @param mixed $value The value associated with the field.
     * @param string $type The type of the field.
     * @param string $label The label for the field.
     * @param bool $readonly Indicates if the field is read-only.
     * @param bool $hidden Indicates if the field is hidden.
     * @param mixed $valueDraft The draft value associated with the field.
     * @return self The current instance for method chaining.
     */
    public function appendData($field, $value, $type, $label, $readonly, $hidden, $valueDraft)
    {
        if (!isset($this->columns)) {
            $this->columns = array(); // Initialize as an array if not set
        }

        $this->columns[] = new ColumnDto($field, $value, $type, $label, $readonly, $hidden, $valueDraft);
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get an array of columns, each represented as a ColumnDto.
     *
     * @return ColumnDto[] The columns in the data structure.
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set an array of columns, each represented as a ColumnDto.
     *
     * @param ColumnDto[] $columns An array of columns to set.
     * @return self The current instance for method chaining.
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get metadata associated with the row.
     *
     * @return MetadataDto The metadata associated with the row.
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set metadata associated with the row.
     *
     * @param MetadataDto $metadata Metadata to associate with the row.
     * @return self The current instance for method chaining.
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this; // Return current instance for method chaining.
    }
}
