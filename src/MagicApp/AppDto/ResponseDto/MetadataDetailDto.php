<?php

namespace MagicApp\AppDto\ResponseDto;

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
