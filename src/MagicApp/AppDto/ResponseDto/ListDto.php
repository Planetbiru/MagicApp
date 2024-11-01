<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;
use MagicObject\SetterGetter;
use MagicObject\Util\PicoGenericObject;
use stdClass;

/**
 * Data Transfer Object (DTO) for displaying records in a table format.
 */
class ListDto
{
    /**
     * The response code indicating the status of the request.
     *
     * @var string|null
     */
    protected $responseCode;
    
    /**
     * A message providing additional information about the response.
     *
     * @var string|null
     */
    protected $responseMessage;
    
    /**
     * The name of the primary key in the data structure.
     *
     * @var string[]|null
     */
    protected $primaryKeyName;
    
    /**
     * Data map
     *
     * @var DataMap[]
     */
    protected $dataMap;
    
    /**
     * An associative array mapping primary key names to their data types.
     *
     * @var string[]
     */
    protected $primaryKeyDataType;
    
    /**
     * The main data structure containing the list of items.
     *
     * @var ListDataDto|null
     */
    protected $data;

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
     * Append a row of data to the table.
     *
     * @param MagicObject $data The row data to append.
     * @return self The current instance for method chaining.
     */
    public function appendData($data)
    {
        if(!isset($this->data))
        {
            $this->data = new ListDataDto();
        }   
        $this->data->appendData($data);
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
     * Get the main data structure containing the list of items.
     *
     * @return ListDataDto|null The main data structure.
     */ 
    public function getData()
    {
        return $this->data;
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
        $value = clone $this;
        return json_encode($value);
    }
}
