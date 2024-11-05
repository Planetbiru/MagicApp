<?php

namespace MagicApp\AppDto\ResponseDto;

class ColumnDto
{
    /**
     * Data associated with the row.
     *
     * @var ColumnDataDto[]
     */
    public $data;

    /**
     * Metadata associated with the row.
     *
     * @var MetadataDto
     */
    public $metadata;

    /**
     * Get metadata associated with the row.
     *
     * @return MetadataDto The metadata associated with the row.
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set metadata associated with the row.
     *
     * @param MetadataDto $metadata Metadata to associate with the row.
     * @return self The current instance for method chaining.
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this; // Return current instance for method chaining.
    }

    public function __construct()
    {
        $this->data = [];
        $this->metadata = new MetadataDto();
    }
}