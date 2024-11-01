<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Represents the title of a column in a table row.
 */
class ListDataTitleDto
{
    /**
     * The key associated with the column title.
     *
     * @var string|null
     */
    protected $key;
    
    /**
     * The display value of the column title.
     *
     * @var string|null
     */
    protected $value;
    
    /**
     * Constructor to initialize the column title.
     *
     * @param string|null $key The key associated with the column title.
     * @param string|null $value The display value of the column title.
     */
    public function __construct($key = null, $value = null)
    {
        if(isset($key))
        {
            $this->key = $key;
        }
        if(isset($value))
        {
            $this->value = $value;
        }
    }

    /**
     * Get the key associated with the column title.
     *
     * @return string|null The key associated with the column title.
     */ 
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the key associated with the column title.
     *
     * @param string $key The key associated with the column title.
     * @return self
     */
    public function setKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the display value of the column title.
     *
     * @return string|null The display value of the column title.
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the display value of the column title.
     *
     * @param string $value The display value of the column title.
     * @return self
     */ 
    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }
}
