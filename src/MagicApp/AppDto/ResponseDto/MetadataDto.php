<?php

namespace MagicApp\AppDto\ResponseDto;

class MetadataDto
{
    /**
     * Associated array key value primary key.
     *
     * @var array
     */
    private $primaryKey;

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
    private $waitingFor;

    /**
     * Indicates whether the metadata is active.
     *
     * @var bool
     */
    private $active;

    /**
     * Constructor to initialize properties of the MetadataDto class.
     *
     * @param array $primaryKey An array representing the primary key.
     * @param int $waitingFor An integer representing the operation status.
     * @param bool $active A boolean indicating if the metadata is active.
     */
    public function __construct($primaryKey, $waitingFor, $active)
    {
        $this->primaryKey = $primaryKey;
        $this->waitingFor = $waitingFor;
        $this->active = $active;
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
