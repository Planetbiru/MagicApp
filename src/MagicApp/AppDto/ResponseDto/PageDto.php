<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\Database\PicoPageable;

/**
 * Class PageDto
 *
 * Represents an object that handles pagination details, including the page number,
 * page size, and the data offset. This class facilitates the management of pagination 
 * for collections of data. It can either initialize from a PicoPageable object or 
 * default to the first page with one item.
 *
 * @package MagicApp\AppDto\ResponseDto
 */
class PageDto extends ToString
{
    /**
     * The current page number
     *
     * @var int
     */
    public $pageNumber;

    /**
     * The page size, i.e., the number of items displayed per page
     *
     * @var int
     */
    public $pageSize;

    /**
     * The data offset, which is used to calculate the starting position of data on 
     * the current page.
     *
     * @var int
     */
    public $dataOffset;

    /**
     * Constructor for the PageDto class.
     * 
     * This constructor initializes the page number, page size, and data offset.
     * If a PicoPageable object is provided, it uses its pagination details. 
     *
     * @param PicoPageable|null $pagable An optional object that provides pagination 
     *                                    details (e.g., page number, page size).
     */
    public function __construct($pagable = null)
    {
        if (isset($pagable)) {
            // Initialize from the PicoPageable object
            $this->pageNumber = $pagable->getPage()->getPageNumber();
            $this->pageSize = $pagable->getPage()->getPageSize();
            $this->dataOffset = ($this->pageNumber - 1) * $this->pageSize;
        }
    }

    /**
     * Gets the current page number.
     *
     * @return int The current page number.
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Sets the current page number.
     *
     * @param int $pageNumber The page number to set.
     * 
     * @return self Returns the current instance for chaining.
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    /**
     * Gets the page size (the number of items per page).
     *
     * @return int The page size.
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Sets the page size.
     *
     * @param int $pageSize The page size to set.
     * 
     * @return self Returns the current instance for chaining.
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * Gets the data offset (the starting position of data on the current page).
     *
     * @return int The data offset.
     */
    public function getDataOffset()
    {
        return $this->dataOffset;
    }

    /**
     * Sets the data offset.
     *
     * @param int $dataOffset The data offset to set.
     * 
     * @return self Returns the current instance for chaining.
     */
    public function setDataOffset($dataOffset)
    {
        $this->dataOffset = $dataOffset;

        return $this;
    }
}
