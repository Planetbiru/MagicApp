<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;

/**
 * Class ResponseDto
 *
 * Represents a data transfer object for API responses.
 * This class holds the response code, message, and associated data.
 */
class ResponseDto extends MagicObject
{
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
     * The data associated with the response.
     *
     * @var mixed
     */
    public $data;

    /**
     * Constructor to initialize properties.
     *
     * @param string|null $responseCode The response code.
     * @param string|null $responseMessage The response message.
     * @param mixed $data The associated data.
     */
    public function __construct($responseCode = null, $responseMessage = null, $data = null)
    {
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
        $this->data = $data;
    }

    /**
     * Get the response code.
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set the response code.
     *
     * @param string|null $responseCode The response code to set.
     * @return self
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * Get the response message.
     *
     * @return string|null
     */
    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * Set the response message.
     *
     * @param string|null $responseMessage The response message to set.
     * @return self
     */
    public function setResponseMessage($responseMessage)
    {
        $this->responseMessage = $responseMessage;
        return $this;
    }

    /**
     * Get the associated data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the associated data.
     *
     * @param mixed $data The data to set.
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Convert the ListDto instance to a JSON string representation.
     *
     * This method clones the current instance and encodes it into a JSON format.
     *
     * @return string JSON representation of the ListDto instance.
     */ 
    public function __toString()
    {
        return json_encode([
            'responseCode' => $this->responseCode,
            'responseMessage' => $this->responseMessage,
            'data' => $this->data,
        ], JSON_PRETTY_PRINT);
    }
}
