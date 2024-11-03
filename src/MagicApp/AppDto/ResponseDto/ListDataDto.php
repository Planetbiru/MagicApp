<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;

/**
 * Class ListDataDto
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
class ListDataDto extends ToString
{
    
    /**
     * An array of column titles for the data table.
     *
     * @var ListDataTitleDto[]
     */
    public $title;
    
    /**
     * An array of data map for the data table.
     *
     * @var DataMap[]
     */
    public $dataMap;
    
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
     * An array of rows, each represented as a RowDto.
     *
     * @var RowDto[]
     */
    public $rows;

    /**
     * Get the name of the primary key in the data structure.
     *
     * @return string[]|null
     */ 
    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

    /**
     * Set the name of the primary key in the data structure.
     *
     * @param  string[]|null  $primaryKeyName  The name of the primary key in the data structure.
     *
     * @return  self The current instance for method chaining.
     */ 
    public function setPrimaryKeyName($primaryKeyName)
    {
        $this->primaryKeyName = $primaryKeyName;

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
        if (!isset($this->primaryKeyName)) {
            $this->primaryKeyName = []; // Initialize as an array if not set
            $this->primaryKeyDataType = []; // Initialize as an array if not set
        }   
        $this->primaryKeyName[] = $primaryKeyName; // Append the primary key name
        $this->primaryKeyDataType[$primaryKeyName] = $primaryKeyDataType; // Append the primary key data type
        return $this;
    }
    
    /**
     * Append a column title to the table.
     *
     * @param ListDataTitleDto $title The title to append.
     * @return self The current instance for method chaining.
     */
    public function appendTitle($title)
    {
        if (!isset($this->title)) {
            $this->title = array();
        }
        
        $this->title[] = $title;
        
        return $this;
    }
    
    /**
     * Append a data map to the table.
     *
     * @param mixed $dataMap The data map to append.
     * @return self The current instance for method chaining.
     */
    public function appendDataMap($dataMap)
    {
        if (!isset($this->dataMap)) {
            $this->dataMap = array();
        }
        
        $this->dataMap[] = $dataMap;
        
        return $this;
    }
    
    /**
     * Append a row of data to the table.
     *
     * This method adds a new row to the internal rows collection using the provided
     * MagicObject as data along with the associated MetadataDto.
     *
     * @param MagicObject $data The row data to append.
     * @param MetadataDto $metadata The metadata associated with the row data.
     * @return self The current instance for method chaining.
     */
    public function appendData($data, $metadata)
    {
        if (!isset($this->rows)) {
            $this->rows = array();
        }
        
        $this->rows[] = new RowDto($data, $metadata);
        
        return $this; // Return current instance for method chaining.
    }



    /**
     * Get an array of column titles for the data table.
     *
     * @return ListDataTitleDto[] The column titles.
     */ 
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Reset the column titles to an empty array.
     *
     * @return self The current instance for method chaining.
     */
    public function resetTitle()
    {
        $this->title = [];
        return $this;
    }

    /**
     * Get the data map for the table.
     *
     * @return DataMap The data map.
     */ 
    public function getDataMap()
    {
        return $this->dataMap;
    }
    
    /**
     * Reset the data map to an empty array.
     *
     * @return self The current instance for method chaining.
     */
    public function resetDataMap()
    {
        $this->dataMap = []; // Assuming you want to set it to an empty array
        return $this;
    }
    
    /**
     * Get an array of rows for the data table.
     *
     * @return RowDto[] The rows of data.
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Reset the rows to an empty array.
     *
     * @return self The current instance for method chaining.
     */
    public function resetRows()
    {
        $this->rows = array();
        return $this;
    }
}
