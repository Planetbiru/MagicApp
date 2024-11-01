<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) for displaying record in a table format.
 */
class DetailDto
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
     * The value of the primary key, which can be of any type.
     *
     * @var mixed
     */
    protected $primaryKeyValue;

    /**
     * Code indicating the waiting status.
     *
     * @var int
     */
    protected $waitingForCode;

    /**
     * Action indicating what is being awaited.
     *
     * @var string
     */
    protected $waitingForAction;

    /**
     * Message providing details about what is being awaited.
     *
     * @var string
     */
    protected $waitingForMessage;

    /**
     * The main data structure containing the list of items.
     *
     * @var DetailDataDto|null
     */
    protected $data;

    /**
     * Get the response code indicating the status of the request.
     *
     * @return string|null The response code indicating the status of the request.
     */ 
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set the response code indicating the status of the request.
     *
     * @param string|null $responseCode The response code indicating the status of the request.
     * @return self The instance of this class.
     */ 
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * Get a message providing additional information about the response.
     *
     * @return string|null The response message.
     */ 
    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * Set a message providing additional information about the response.
     *
     * @param string|null $responseMessage A message providing additional information about the response.
     * @return self The instance of this class.
     */ 
    public function setResponseMessage($responseMessage)
    {
        $this->responseMessage = $responseMessage;
        return $this;
    }

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
     * @return self The instance of this class.
     */ 
    public function setPrimaryKeyName($primaryKeyName)
    {
        $this->primaryKeyName = $primaryKeyName;
        return $this;
    }

    /**
     * Get the value of the primary key, which can be of any type.
     *
     * @return mixed The value of the primary key.
     */ 
    public function getPrimaryKeyValue()
    {
        return $this->primaryKeyValue;
    }

    /**
     * Set the value of the primary key, which can be of any type.
     *
     * @param mixed $primaryKeyValue The value of the primary key.
     * @return self The instance of this class.
     */  
    public function setPrimaryKeyValue($primaryKeyValue)
    {
        $this->primaryKeyValue = $primaryKeyValue;
        return $this;
    }

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
     * Append a column of data to the detail structure.
     *
     * @param DetailColumnDto $data The column data to append.
     * @return self The instance of this class.
     */
    public function appendData($data)
    {
        if (!isset($this->data)) {
            $this->data = new DetailDataDto();
        }   
        $this->data->appendData($data);
        return $this;
    }

    /**
     * Add a new detail column.
     *
     * This method creates a new DetailColumnDto and appends it to the detail data structure.
     *
     * @param string $field The field associated with the detail.
     * @param mixed $value The value associated with the detail.
     * @param string|null $type The type describing the detail.
     * @param string|null $label The label describing the detail.
     * @param bool $readonly Whether the detail is readonly.
     * @param bool $hidden Whether the detail is hidden.
     * @param mixed|null $valueDraft The value associated with the draft data.
     * @return self The instance of this class.
     */
    public function addData($field, $value, $type = null, $label = null, $readonly = false, $hidden = false, $valueDraft = null)
    {
        if (!isset($this->data)) {
            $this->data = new DetailDataDto();
        }   
        $this->data->appendData(new DetailColumnDto($field, $value, $type, $label, $readonly, $hidden, $valueDraft));
        return $this;
    }
    
    /**
     * Add a primary key name to the list of primary keys.
     *
     * This method initializes the primary key name property as an array if it hasn't been set,
     * then appends the new primary key name to the list.
     *
     * @param string $primaryKeyName The primary key name to add.
     * @return self The instance of this class.
     */
    public function addPrimaryKeyName($primaryKeyName)
    {
        if (!isset($this->primaryKeyName)) {
            $this->primaryKeyName = []; // Initialize as an array if not set
        }   
        $this->primaryKeyName[] = $primaryKeyName; // Append the primary key name
        return $this;
    }


    /**
     * Get the waiting status code.
     *
     * @return int The waiting status code.
     */ 
    public function getWaitingForCode()
    {
        return $this->waitingForCode;
    }

    /**
     * Set the waiting status code.
     *
     * @param int $waitingForCode The waiting status code.
     * @return self The instance of this class.
     */ 
    public function setWaitingForCode($waitingForCode)
    {
        $this->waitingForCode = $waitingForCode;
        return $this;
    }

    /**
     * Get the action indicating what is being awaited.
     *
     * @return string The action being awaited.
     */ 
    public function getWaitingForAction()
    {
        return $this->waitingForAction;
    }

    /**
     * Set the action indicating what is being awaited.
     *
     * @param string $waitingForAction The action being awaited.
     * @return self The instance of this class.
     */ 
    public function setWaitingForAction($waitingForAction)
    {
        $this->waitingForAction = $waitingForAction;
        return $this;
    }

    /**
     * Get the message providing details about what is being awaited.
     *
     * @return string The message about the waiting status.
     */ 
    public function getWaitingForMessage()
    {
        return $this->waitingForMessage;
    }

    /**
     * Set the message providing details about what is being awaited.
     *
     * @param string $waitingForMessage The message about the waiting status.
     * @return self The instance of this class.
     */ 
    public function setWaitingForMessage($waitingForMessage)
    {
        $this->waitingForMessage = $waitingForMessage;
        return $this;
    }
    
    /**
     * Convert the DetailDto instance to a JSON string representation.
     *
     * This method clones the current instance and encodes it into a JSON format.
     *
     * @return string JSON representation of the DetailDto instance.
     */ 
    public function __toString()
    {
        $value = clone $this;
        return json_encode($value);
    }
}
