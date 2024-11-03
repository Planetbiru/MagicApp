<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;
use MagicObject\SetterGetter;
use MagicObject\Util\PicoGenericObject;
use stdClass;

/**
 * Data Transfer Object (DTO) for displaying records in a table format.
 * 
 * This class provides a structured way to manage data for a module, 
 * including metadata about the response and pagination details.
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
     * @param ListDataDto|null $data The associated data.
     */
    public function __construct($responseCode = null, $responseMessage = null, $data = null)
    {
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
        $this->data = $data;
    }

    /**
     * Append a column title to the data structure.
     *
     * @param ListDataTitleDto $title The title to append.
     * @return self The current instance for method chaining.
     */
    public function appendTitle($title)
    {
        if ($this->data && $this->data->getTitle() === null) {
            $this->data->resetTitle();
        }
        
        $this->data->appendTitle($title);
        
        return $this;
    }
    
    /**
     * Add a data map to the collection.
     *
     * Initializes the data map collection if it doesn't exist, 
     * then appends a DataMap instance to the internal data structure.
     *
     * @param DataMap $dataMap The DataMap instance to add.
     * @return self The current instance for method chaining.
     */
    public function addDataMap($dataMap)
    {
        if ($this->data && $this->data->getDataMap() === null) {
            $this->data->resetDataMap();
        }
        
        $this->data->appendDataMap($dataMap);
        
        return $this; // Return the current instance for method chaining
    }
    
    /**
     * Add a title to the table.
     *
     * Accepts various types of input to create a column title.
     * Supports associative arrays, stdClass objects, and specific MagicObject instances.
     *
     * @param array|stdClass|MagicObject|SetterGetter|PicoGenericObject $title The title to add.
     * @return self Returns the current instance for method chaining.
     */
    public function add($title)
    {
        if ($this->data && $this->data->getTitle() === null) {
            $this->data->resetTitle();
        }     
        
        $finalTitle = null;     
        if ($title instanceof stdClass && isset($title->key) && isset($title->value)) {
            $finalTitle = new ListDataTitleDto($title->key, $title->value);
        } elseif (is_array($title) && isset($title['key']) && isset($title['value'])) {
            $finalTitle = new ListDataTitleDto($title['key'], $title['value']);
        } elseif (($title instanceof MagicObject || $title instanceof SetterGetter || $title instanceof PicoGenericObject) && $title->issetKey() && $title->issetValue()) {
            $finalTitle = new ListDataTitleDto($title->getKey(), $title->getValue());
        }

        if (isset($finalTitle)) {
            $this->data->appendTitle($finalTitle);
        }
        
        return $this;
    }

    /**
     * Append a row of data to the table.
     *
     * This method adds a new row of data to the internal collection,
     * creating a ListDataDto instance if it doesn't already exist.
     *
     * @param MagicObject $data The row data to append.
     * @param MetadataDto $metadata The metadata associated with the row data.
     * @return self The current instance for method chaining.
     */
    public function appendData($data, $metadata)
    {
        if (!isset($this->data)) {
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
     * @param string|null $responseCode The response code indicating the status of the request.
     * @return self The current instance for method chaining.
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
     * @param string|null $responseMessage A message providing additional information about the response.
     * @return self The current instance for method chaining.
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
