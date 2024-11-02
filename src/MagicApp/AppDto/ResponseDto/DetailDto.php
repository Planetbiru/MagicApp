<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) for displaying record in a table format.
 */
class DetailDto extends ResponseDto
{
    /**
     * The main data structure containing the list of items.
     *
     * @var DetailDataDto
     */
    public $data;

    /**
     * Get the main data structure containing the detail columns.
     *
     * @return DetailDataDto|null The detail data structure.
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Append a column of data to the detail structure.
     *
     * @param DetailColumnDto $data The column data to append.
     * @return self The instance of this class.
     */
    public function appendData($data)
    {
        $this->data->appendData($data);
        return $this;
    }

    /**
     * Add a new detail column.
     *
     * This method creates a new DetailColumnDto and appends it to the detail data structure.
     *
     * @param string $field The field associated with the detail.
     * @param mixed $value The value associated with the detail.
     * @param string|null $label The label describing the detail.
     * @param bool $readonly Whether the detail is readonly.
     * @param bool $hidden Whether the detail is hidden.
     * @param mixed|null $valueDraft The value associated with the draft data.
     * @return self The instance of this class.
     */
    public function addData($field, $value, $type = null, $label = null, $readonly = false, $hidden = false, $valueDraft = null)
    {
        $this->data->appendData(new ColumnDto($field, $value, $type, $label, $readonly, $hidden, $valueDraft));
        return $this;
    }

}
