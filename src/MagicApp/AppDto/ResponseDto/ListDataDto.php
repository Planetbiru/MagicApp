<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;

/**
 * Class ListDataDto
 *
 * Represents the data structure for a table, including column titles and rows.
 * This class manages the titles of columns, a data map, and the rows of data 
 * represented as MagicObject instances. It provides methods for appending 
 * titles, data maps, and rows, as well as resetting these structures.
 */
class ListDataDto
{
    /**
     * An array of column titles for the data table.
     *
     * @var ListDataTitleDto[]
     */
    protected $title;
    
    /**
     * An array of data map for the data table.
     *
     * @var DataMap[]
     */
    protected $dataMap;
    
    /**
     * An array of rows, each represented as a MagicObject.
     *
     * @var MagicObject[]
     */
    protected $rows;
    
    /**
     * Append a column title to the table.
     *
     * @param ListDataTitleDto $title The title to append.
     * @return self The current instance for method chaining.
     */
    public function appendTitle($title)
    {
        if (!isset($this->title)) {
            $this->title = array();
        }
        
        $this->title[] = $title;
        
        return $this;
    }
    
    /**
     * Append a data map to the table.
     *
     * @param mixed $dataMap The data map to append.
     * @return self The current instance for method chaining.
     */
    public function appendDataMap($dataMap)
    {
        if (!isset($this->dataMap)) {
            $this->dataMap = array();
        }
        
        $this->dataMap[] = $dataMap;
        
        return $this;
    }
    
    /**
     * Append a row of data to the table.
     *
     * @param MagicObject $data The row data to append.
     * @return self The current instance for method chaining.
     */
    public function appendData($data)
    {
        if (!isset($this->rows)) {
            $this->rows = array();
        }
        
        $this->rows[] = $data;
        
        return $this;
    }

    /**
     * Get an array of column titles for the data table.
     *
     * @return ListDataTitleDto[] The column titles.
     */ 
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Reset the column titles to an empty array.
     *
     * @return self The current instance for method chaining.
     */
    public function resetTitle()
    {
        $this->title = [];
        return $this;
    }

    /**
     * Get the data map for the table.
     *
     * @return DataMap The data map.
     */ 
    public function getDataMap()
    {
        return $this->dataMap;
    }
    
    /**
     * Reset the data map to an empty array.
     *
     * @return self The current instance for method chaining.
     */
    public function resetDataMap()
    {
        $this->dataMap = []; // Assuming you want to set it to an empty array
        return $this;
    }
    
    /**
     * Get an array of rows for the data table.
     *
     * @return MagicObject[] The rows of data.
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Reset the rows to an empty array.
     *
     * @return self The current instance for method chaining.
     */
    public function resetRows()
    {
        $this->rows = array();
        return $this;
    }
}
