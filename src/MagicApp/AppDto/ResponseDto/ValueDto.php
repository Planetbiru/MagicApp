<?php

namespace MagicApp\AppDto\ResponseDto;

class ValueDto
{
    /**
     * Data to be displayed.
     *
     * @var mixed
     */
    public $display;

    /**
     * Raw data.
     *
     * @var mixed
     */
    public $raw;

    /**
     * Constructor to initialize properties of the ValueDto class.
     *
     * If the raw data is not provided, it defaults to the display data.
     *
     * @param mixed $display The data to be displayed.
     * @param mixed|null $raw The raw data.
     */
    public function __construct($display = null, $raw = null)
    {
        $this->display = $display;
        if ($raw != null) {
            $this->raw = $raw;
        }
    }

    /**
     * Get the data to be displayed.
     *
     * @return mixed The data to be displayed.
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set the data to be displayed and return the current instance for method chaining.
     *
     * @param mixed $display The data to set for display.
     * @return self The current instance for method chaining.
     */
    public function setDisplay($display)
    {
        $this->display = $display;
        return $this; // Return current instance for method chaining.
    }

    /**
     * Get the raw data.
     *
     * @return mixed The raw data.
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Set the raw data and return the current instance for method chaining.
     *
     * @param mixed $raw The raw data to set.
     * @return self The current instance for method chaining.
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this; // Return current instance for method chaining.
    }
}
