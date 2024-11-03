<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) representing detailed metadata information.
 * 
 * The MetadataDetailDto class extends the MetadataDto class to provide 
 * specific details related to metadata associated with data operations. 
 * It includes properties that indicate the status of operations, the 
 * primary key associated with the metadata, and its active status. 
 * This class is particularly useful for scenarios where detailed 
 * tracking of metadata operations is required, such as in data 
 * approval processes, updates, or state changes.
 * 
 * The class provides methods for accessing and manipulating these properties 
 * while leveraging inheritance from the MetadataDto class for common metadata 
 * functionalities.
 * 
 * The class extends the ToString base class, enabling string representation based on 
 * the specified property naming strategy.
 * 
 * @package MagicApp\AppDto\ResponseDto
 * @author Kamshory
 * @link https://github.com/Planetbiru/MagicApp
 */
class MetadataDetailDto extends MetadataDto
{
    /**
     * Associated array key value primary key.
     *
     * @var array
     */
    public $primaryKey;

    /**
     * Indicates whether the metadata is active.
     *
     * @var bool
     */
    public $active;

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
     * Code representing the waiting status.
     *
     * @var string
     */
    public $waitingForCode;

    /**
     * Message associated with the waiting status.
     *
     * @var string
     */
    public $waitingForMessage;

    /**
     * Constructor to initialize properties of the MetadataDetailDto class.
     *
     * @param array $primaryKey An array representing the primary key.
     * @param bool $active A boolean indicating if the metadata is active.
     * @param int $waitingFor An integer representing the operation status.
     * @param string $waitingForCode A code representing the waiting status.
     * @param string $waitingForMessage A message associated with the waiting status.
     */
    public function __construct($primaryKey, $active, $waitingFor, $waitingForCode, $waitingForMessage)
    {
        parent::__construct($primaryKey, $active, $waitingFor); // Call parent constructor
        $this->waitingForCode = $waitingForCode;
        $this->waitingForMessage = $waitingForMessage;
    }
}
