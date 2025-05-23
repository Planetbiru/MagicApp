<?php

namespace MagicApp\AppDto\MocroServices;

/**
 * Class PicoUserFormFilterList
 *
 * Represents a list of filters to be displayed above a data list in a user form. 
 * This class holds a collection of `InputFieldFilter` objects, each representing 
 * an individual filter field that can be applied to the data list. Filters are 
 * added to the list using the constructor or the `addFilter` method.
 *
 * @package MagicApp\AppDto\MocroServices
 */
class PicoUserFormFilterList extends PicoObjectToString
{
    /**
     * An array of filter fields to be applied to the data list.
     * Each filter is represented by an `InputFieldFilter` object.
     *
     * @var InputFieldFilter[]
     */
    protected $filters;

    /**
     * An array of HTML elements to be displayed in the filter list.
     * Each element is either a `PicoHtmlElement` object or can be converted into one.
     *
     * @var PicoHtmlElement[]
     */
    protected $elements;
    
    /**
     * Constructor for initializing the filter list.
     *
     * This constructor initializes an empty filter list and optionally adds a 
     * filter if provided. The filter is an instance of the `InputFieldFilter` class.
     *
     * @param InputFieldFilter|null $filter An optional filter to add to the list.
     */
    public function __construct($filter = null)
    {
        $this->filters = [];
        $this->elements = [];

        if (isset($filter)) {
            $this->filters[] = $filter;
        }
    }
    
    /**
     * Add a filter to the filter list.
     *
     * This method allows for adding an `InputFieldFilter` object to the list of filters.
     *
     * @param InputFieldFilter $filter The filter to be added to the list.
     * @return self Returns the current instance for method chaining.
     */
    public function addFilter($filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Adds an HTML element to the list of visual elements for the filter list UI.
     *
     * The input can either be a `PicoHtmlElement` object or an associative array
     * with the appropriate keys (`tag`, `textNode`, `attributes`, `link`) that 
     * will be used to construct a `PicoHtmlElement` instance.
     *
     * @param PicoHtmlElement|array $element The element to add.
     * @return self Returns the current instance for method chaining.
     */
    public function addElement($element)
    {
        if (!isset($this->elements)) {
            $this->elements = [];
        }

        if (isset($element) && is_array($element)) {
            $this->elements[] = new PicoHtmlElement($element);
        } else {
            $this->elements[] = $element;
        }

        return $this;
    }
}
