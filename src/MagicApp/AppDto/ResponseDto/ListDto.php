<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;
use MagicObject\SetterGetter;
use MagicObject\Util\PicoGenericObject;
use stdClass;

/**
 * Data Transfer Object (DTO) for displaying records in a table format.
 * 
 * The class extends the ToString base class, enabling string representation based on 
 * the specified property naming strategy.
 * 
 * @package MagicApp\AppDto\ResponseDto
 * @author Kamshory
 * @link https://github.com/Planetbiru/MagicApp
 */
class ListDto extends ToString
{
    /**
     * The ID of the module associated with the data.
     *
     * @var string
     */
    public $moduleId;

    /**
     * The name of the module associated with the data.
     *
     * @var string
     */
    public $moduleName;

    /**
     * The title of the module associated with the data.
     *
     * @var string
     */
    public $moduleTitle;

    /**
     * The current page number for paginated data.
     *
     * @var int
     */
    public $pageNumber;

    /**
     * The number of items per page for pagination.
     *
     * @var int
     */
    public $pageSize;

    /**
     * The response code indicating the status of the request.
     *
     * @var string|null
     */
    public $responseCode;

    /**
     * A message providing additional information about the response.
     *
     * @var string|null
     */
    public $responseMessage;

    /**
     * The main data structure containing the list of items.
     *
     * @var ListDataDto|null
     */
    public $data;

    /**
     * Constructor to initialize properties.
     *
     * @param string|null $responseCode The response code.
     * @param string|null $responseMessage The response message.
     * @param mixed $data The associated data.
     */
    public function __construct($responseCode = null, $responseMessage = null, $data = null)
    {
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
        $this->data = $data;
    }

    /**
     * Append a column title to the table.
     *
     * @param ListDataTitleDto $title The title to append.
     * @return self The current instance for method chaining.
     */
    public function appendTitle($title)
    {
        if($this->data->getTitle() == null)
        {
            $this->data->resetTitle();
        }
        
        $this->data->appendTitle($title);
        
        return $this;
    }
    
    /**
     * Add a data map to the collection.
     *
     * This method appends a DataMap instance to the internal data map collection.
     * If the collection does not exist, it initializes it first. Each DataMap is 
     * stored in the data structure.
     *
     * @param DataMap $dataMap The DataMap instance to add.
     * @return self The current instance for method chaining.
     */
    public function addDataMap($dataMap)
    {
        // Check if the data map is initialized; if not, reset it
        if ($this->data->getDataMap() == null) {
            $this->data->resetDataMap();
        }
        
        // Append the DataMap instance to the data structure
        $this->data->appendDataMap($dataMap);
        
        return $this; // Return the current instance for method chaining
    }
    
    /**
     * Add a column title to the table.
     *
     * This method accepts various types of input to create a column title,
     * including associative arrays, stdClass objects, and instances of
     * MagicObject, SetterGetter, or PicoGenericObject. It extracts the key
     * and value for the title and appends it to the data structure.
     *
     * @param array|stdClass|MagicObject|SetterGetter|PicoGenericObject $title The title to add, which can be:
     * - An associative array with 'key' and 'value' elements.
     * - A stdClass object with 'key' and 'value' properties.
     * - An instance of MagicObject, SetterGetter, or PicoGenericObject 
     *   that has methods `getKey()` and `getValue()`.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function add($title)
    {
        if($this->data->getTitle() == null)
        {
            $this->data->resetTitle();
        }     
        $finalTitle = null;     
        if($title instanceof stdClass && isset($title->key) && isset($title->value))
        {
            $finalTitle = new ListDataTitleDto($title->key, $title->value);
        }
        else if(is_array($title) && isset($title['key']) && isset($title['value']))
        {
            $finalTitle = new ListDataTitleDto($title['key'], $title['value']);
        }
        else if(($title instanceof MagicObject || $title instanceof SetterGetter || $title instanceof PicoGenericObject) && $title->issetKey() && $title->issetValue())
        {
            $finalTitle = new ListDataTitleDto($title->getKey(), $title->getValue());
        }
        if(isset($finalTitle))
        {
            $this->data->appendTitle($finalTitle);
        }
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
        if (!isset($this->data->dataMap)) {
            $this->data->dataMap = array();
        }
        
        $this->data->dataMap[] = $dataMap;
        
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
            $this->data->primaryKeyDataType = []; // Initialize as an array if not set
        }   
        $this->data->primaryKeyName[] = $primaryKeyName; // Append the primary key name
        $this->data->primaryKeyDataType[$primaryKeyName] = $primaryKeyDataType; // Append the primary key data type
        return $this;
    }
    
    /**
     * Append a row of data to the table.
     *
     * This method adds a new row of data to the internal data collection,
     * creating a ListDataDto instance if it doesn't already exist.
     *
     * @param MagicObject $data The row data to append.
     * @param MetadataDto $metadata The metadata associated with the row data.
     * @return self The current instance for method chaining.
     */
    public function appendData($data, $metadata)
    {
        if(!isset($this->data))
        {
            $this->data = new ListDataDto();
        }   
        $this->data->appendData($data, $metadata);
        return $this;
    }

    /**
     * Get the response code indicating the status of the request.
     *
     * @return string|null
     */ 
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set the response code indicating the status of the request.
     *
     * @param  string|null  $responseCode  The response code indicating the status of the request.
     *
     * @return  self The current instance for method chaining.
     */ 
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    /**
     * Get a message providing additional information about the response.
     *
     * @return string|null
     */ 
    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * Set a message providing additional information about the response.
     *
     * @param  string|null  $responseMessage  A message providing additional information about the response.
     *
     * @return  self The current instance for method chaining.
     */ 
    public function setResponseMessage($responseMessage)
    {
        $this->responseMessage = $responseMessage;

        return $this;
    }

    /**
     * Get the main data structure containing the list of items.
     *
     * @return ListDataDto|null The main data structure.
     */ 
    public function getData()
    {
        return $this->data;
    }

}
