<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;

/**
 * Represents the data structure for a table, including column titles and rows.
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
     * An array of rows, each represented as a MagicObject.
     *
     * @var MagicObject[]
     */
    protected $rows;
    
    /**
     * Append a column title to the table.
     *
     * @param ListDataTitleDto $title The title to append.
     * @return self
     */
    public function appendTitle($title)
    {
        if(!isset($this->title))
        {
            $this->title = [];
        }
        
        $this->title[] = $title;
        
        return $this;
    }
    
    /**
     * Append a row of data to the table.
     *
     * @param MagicObject $data The row data to append.
     * @return self
     */
    public function appendData($data)
    {
        if(!isset($this->rows))
        {
            $this->rows = [];
        }
        
        $this->rows[] = $data;
        
        return $this;
    }

    /**
     * Get an array of column titles for the data table.
     *
     * @return  ListDataTitleDto[]
     */ 
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Reset title
     *
     * @return void
     */
    public function resetTitle()
    {
        $this->title = [];
        return $this;
    }

}
