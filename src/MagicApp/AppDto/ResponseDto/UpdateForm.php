<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class UpdateForm
 *
 * This class represents a form used for updating resources via HTTP methods.
 * It encapsulates the HTTP method, Accept headers, primary key names, and
 * input data necessary for the update operation.
 */
class UpdateForm
{
    /**
     * HTTP method to be used (e.g., POST, GET, PUT).
     *
     * @var string
     */
    protected $method;
    
    /**
     * The Accept header value as used in HTTP requests.
     *
     * @var string
     */
    protected $accept;
    
    /**
     * An array of primary key names.
     *
     * @var string[]
     */
    protected $primaryKeyName;
    
    /**
     * An associative array mapping primary key names to their data types.
     *
     * @var string[]
     */
    protected $primaryKeyDataType;
    
    /**
     * An array of input DTOs.
     *
     * @var InputDto[]
     */
    protected $input;

    /**
     * Get the HTTP method (e.g., POST, GET, PUT).
     *
     * @return string The HTTP method.
     */ 
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the HTTP method (e.g., POST, GET, PUT).
     *
     * @param string $method The HTTP method.
     * @return self The instance of this class.
     */ 
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the Accept header value.
     *
     * @return string The Accept header value.
     */ 
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * Set the Accept header value.
     *
     * @param string $accept The Accept header value.
     * @return self The instance of this class.
     */ 
    public function setAccept(string $accept)
    {
        $this->accept = $accept;

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
     * Append an InputDto instance to the input list.
     *
     * This method initializes the input property as an array if it hasn't been set,
     * then appends the given InputDto instance to the list.
     *
     * @param InputDto $input The InputDto instance to append.
     * @return self The instance of this class.
     */
    public function appendInput(InputDto $input)
    {
        if (!isset($this->input)) {
            $this->input = []; // Initialize as an array if not set
        }   
        $this->input[] = $input; // Append the InputDto instance
        return $this;
    }

    /**
     * Get an array of primary key data types.
     *
     * @return string[] An associative array mapping primary key names to their data types.
     */ 
    public function getPrimaryKeyDataType()
    {
        return $this->primaryKeyDataType;
    }

    /**
     * Set an array of primary key data types.
     *
     * @param string[] $primaryKeyDataType An associative array mapping primary key names to their data types.
     * @return self The instance of this class.
     */ 
    public function setPrimaryKeyDataType(array $primaryKeyDataType)
    {
        $this->primaryKeyDataType = $primaryKeyDataType;

        return $this;
    }
}
