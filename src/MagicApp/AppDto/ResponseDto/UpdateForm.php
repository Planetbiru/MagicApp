<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class UpdateForm
 *
 * Represents the response structure for a list-based form in a UI. This class holds metadata
 * about the module that the form is associated with, such as the module's ID, name, and title,
 * as well as the status of the request (via the response code and message). It also contains
 * the main data structure (`UpdateFormData`) that holds the filter and data controls for the list.
 *
 * The `UpdateForm` class is used to encapsulate all necessary information for rendering a form 
 * that interacts with a list of data. It provides details about the module's context and
 * feedback about the request, as well as the controls and data required for filtering and 
 * displaying the list content in the UI.
 *
 * **Key Features**:
 * - Hold the metadata about the module (ID, name, and title).
 * - Provide the response status and message for request feedback.
 * - Contain the `UpdateFormData` structure, which manages the list's filter and data controls.
 * - Allow easy access to the response details and the data form structure.
 *
 * @package MagicApp\AppDto\ResponseDto
 * @author Kamshory
 * @link https://github.com/Planetbiru/MagicApp
 */
class UpdateForm extends ToString
{
    /**
     * The ID of the module associated with the data.
     *
     * @var string
     */
    public $moduleId;

    /**
     * The name of the module associated with the data.
     *
     * @var string
     */
    public $moduleName;

    /**
     * The title of the module associated with the data.
     *
     * @var string
     */
    public $moduleTitle;

    /**
     * The response code indicating the status of the request.
     *
     * @var string|null
     */
    public $responseCode;

    /**
     * A message providing additional information about the response.
     *
     * @var string|null
     */
    public $responseMessage;

    /**
     * The main data structure containing the list form.
     *
     * @var UpdateFormData|null
     */
    public $data;
}