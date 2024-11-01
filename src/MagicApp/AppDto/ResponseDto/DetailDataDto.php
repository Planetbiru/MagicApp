<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) representing a collection of detail columns.
 */
class DetailDataDto
{
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
     * Array of detail column DTOs.
     *
     * @var DetailColumnDto[]
     */
    protected $column;
    
    /**
     * Append a column of data to the detail.
     *
     * This method adds a new DetailColumnDto to the internal array of columns.
     *
     * @param DetailColumnDto $column The column data to append.
     * @return self
     */
    public function appendData($column)
    {
        if (!isset($this->column)) {
            $this->column = [];
        }
        
        $this->column[] = $column;
        
        return $this;
    }

    /**
     * Get the detail columns.
     *
     * @return DetailColumnDto[] An array of detail column DTOs.
     */
    public function getColumn()
    {
        return $this->column;
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
}
