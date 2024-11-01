<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) representing a collection of detail columns.
 */
class DetailDataDto
{
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
}
