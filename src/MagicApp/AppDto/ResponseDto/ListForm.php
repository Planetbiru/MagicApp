<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class ListForm
 *
 * This class represents a form that encapsulates filter controls and data controls,
 * allowing for the management of user inputs and display elements in a structured manner.
 */
class ListForm
{
    /**
     * An array of ListFilter instances representing filter controls.
     *
     * @var ListFilter[]
     */
    protected $filterControl;

    /**
     * An array of additional features or options associated with the form.
     *
     * @var array
     */
    protected $features;

    /**
     * An array of ListDataControl instances representing data controls (e.g., buttons, inputs).
     *
     * @var ListDataControl[]
     */
    protected $dataControl;

    /**
     * Constructor for initializing a ListForm instance.
     *
     * @param array $filterControl An array of filter controls.
     * @param array $features An array of features.
     * @param array $dataControl An array of data controls.
     */
    public function __construct($filterControl = array(), $features = array(), $dataControl = array())
    {
        $this->filterControl = $filterControl;
        $this->features = $features;
        $this->dataControl = $dataControl;
    }

    /**
     * Get the filter controls.
     *
     * @return array The filter controls.
     */
    public function getFilterControl()
    {
        return $this->filterControl;
    }

    /**
     * Set the filter controls.
     *
     * @param array $filterControl The filter controls.
     * @return self The instance of this class.
     */
    public function setFilterControl($filterControl)
    {
        $this->filterControl = $filterControl;
        return $this;
    }

    /**
     * Append an InputDto instance to the filter controls.
     *
     * @param InputDto $filter The filter control to append.
     * @return self The instance of this class.
     */
    public function appendFilterControl($filter)
    {
        if(!isset($this->filterControl))
        {
            $this->filterControl = [];
        }
        $this->filterControl[] = $filter;
        return $this;
    }

    /**
     * Get the features associated with the form.
     *
     * @return array The features.
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set the features associated with the form.
     *
     * @param array $features The features.
     * @return self The instance of this class.
     */
    public function setFeatures($features)
    {
        $this->features = $features;
        return $this;
    }

    /**
     * Get the data controls.
     *
     * @return array The data controls.
     */
    public function getDataControl()
    {
        return $this->dataControl;
    }

    /**
     * Set the data controls.
     *
     * @param array $dataControl The data controls.
     * @return self The instance of this class.
     */
    public function setDataControl($dataControl)
    {
        $this->dataControl = $dataControl;
        return $this;
    }

    /**
     * Append a ListDataControl instance to the data controls.
     *
     * @param ListDataControl $dataControl The data control to append.
     * @return self The instance of this class.
     */
    public function appendDataControl($dataControl)
    {
        if(!isset($this->dataControl))
        {
            $this->dataControl = [];
        }
        $this->dataControl[] = $dataControl;
        return $this;
    }
}
