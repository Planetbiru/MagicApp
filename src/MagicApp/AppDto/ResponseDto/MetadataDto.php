<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;

class MetadataDto extends ToString
{
    /**
     * Indicates whether the metadata is active.
     *
     * @var bool
     */
    public $active;

    /**
     * Associated array key value primary key.
     *
     * @var array
     */
    public $primaryKey;

    /**
     * Represents the status of the operation.
     * 
     * Possible values:
     * 1 = approval for new data,
     * 2 = updating data,
     * 3 = activate,
     * 4 = deactivate,
     * 5 = delete,
     * 6 = sort order.
     *
     * @var int
     */
    public $waitingFor;

    /**
     * Creates a MetadataDto instance from provided data.
     *
     * This method constructs a MetadataDto by extracting values from a MagicObject
     * based on specified keys for the primary key, waiting status, and active status.
     *
     * @param array $primaryKeyName An array of keys to construct the primary key.
     * @param MagicObject $data The data object from which to extract values.
     * @param string $waitingForKey The key for the waiting status in the data object.
     * @param string $activeKey The key for the active status in the data object.
     * @return MetadataDto An instance of MetadataDto populated with extracted values.
     */
    public static function valueOf(array $primaryKeyName, MagicObject $data, string $waitingForKey, string $activeKey): MetadataDto
    {
        $primaryKey = [];
        
        foreach ($primaryKeyName as $key) {
            $primaryKey[$key] = $data->get($key);
        }
        
        $waitingFor = $data->get($waitingForKey);
        $active = $data->get($activeKey);
        
        return new self($primaryKey, $waitingFor, $active);
    }


    /**
     * Constructor to initialize properties of the MetadataDto class.
     *
     * @param array $primaryKey An array representing the primary key.
     * @param bool $active A boolean indicating if the metadata is active.
     * @param int $waitingFor An integer representing the operation status.
     */
    public function __construct($primaryKey, $active, $waitingFor)
    {
        $this->primaryKey = $primaryKey;
        $this->active = $active;
        $this->waitingFor = $waitingFor;
    }

    /**
     * Get the primary key.
     *
     * @return array The primary key as an array.
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Set the primary key.
     *
     * @param array $primaryKey An array representing the primary key.
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * Get the waiting status.
     *
     * @return int The operation status as an integer.
     */
    public function getWaitingFor()
    {
        return $this->waitingFor;
    }

    /**
     * Set the waiting status.
     * @param int $waitingFor An integer representing the new operation status.
     * @return self The current instance for method chaining.
     */
    public function setWaitingFor($waitingFor)
    {
        $this->waitingFor = $waitingFor;
        return $this;
    }

    /**
     * Get the active status.
     *
     * @return bool True if active, otherwise false.
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the active status.
     *
     * @param bool $active A boolean indicating if the metadata should be active.
     * @return self The current instance for method chaining.
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
}
