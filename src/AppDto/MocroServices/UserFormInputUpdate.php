<?php

namespace MagicApp\AppDto\MocroServices;

/**
 * Class UserFormInputUpdate
 *
 * Represents a collection of input fields for a user form during an update operation.
 * This class manages multiple `InputFieldUpdate` objects, each representing a field 
 * to be updated in the form. It also includes an array of allowed actions (e.g., 
 * `update`, `activate`, `deactivate`, `delete`, `approve`, `reject`) that define 
 * the possible operations that can be performed on the form fields.
 *
 * @package MagicApp\AppDto\MocroServices
 */
class UserFormInputUpdate extends ObjectToString
{
    /**
     * Primary key
     *
     * @var string[]
     */
    protected $primaryKey;

    /**
     * Primary key value
     *
     * @var PrimaryKeyValue[]
     */
    protected $primaryKeyValue;
    
    /**
     * An array of input fields to be updated into the form.
     * Each field is represented by an InputFieldUpdate object.
     *
     * @var InputFieldUpdate[]
     */
    protected $input;
    
    /**
     * Add an allowed action to the input.
     *
     * This method adds an `InputFieldUpdate` object to the list of input that can be performed on the form fields. 
     *
     * @param InputFieldUpdate $input The `InputFieldUpdate` object to be added.
     */
    public function addInput($input)
    {
        if (!isset($this->input)) {
            $this->input = [];
        }
        $this->input[] = $input;
    }

    /**
     * Get primary key
     *
     * @return  string[]
     */ 
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Set primary key
     *
     * @param  string[]  $primaryKey  Primary key
     *
     * @return  self
     */ 
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * Adds a primary key to the collection.
     *
     * This method adds a primary key to the internal array of primary keys.
     * If the collection is not initialized, it initializes it as an empty array before adding the key.
     *
     * @param mixed $primaryKey The primary key to add to the collection
     */
    public function addPrimaryKey($primaryKey)
    {
        if (!isset($this->primaryKey)) {
            $this->primaryKey = [];
        }
        $this->primaryKey[] = $primaryKey;
    }

    /**
     * Adds a primary key value to the collection.
     *
     * This method adds a primary key value to the internal array of primary key values.
     * If the collection is not initialized, it initializes it as an empty array before adding the value.
     *
     * @param PrimaryKeyValue $primaryKeyValue The primary key value to add to the collection
     */
    public function addPrimaryKeyValue($primaryKeyValue)
    {
        if (!isset($this->primaryKeyValue)) {
            $this->primaryKeyValue = [];
        }
        $this->primaryKeyValue[] = $primaryKeyValue;
    }
}
