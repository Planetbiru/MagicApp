<?php

class DataStatusForm
{
    /**
     * HTTP method to be used (e.g., POST, GET, PUT).
     *
     * @var string
     */
    protected $method;
    
    /**
     * The Accept header value as used in HTTP requests.
     *
     * @var string
     */
    protected $accept;
    
    /**
     * An array of primary key names.
     *
     * @var string[]
     */
    protected $primaryKeyName;
    
    /**
     * An array of primary key names.
     *
     * @var string[]
     */
    protected $primaryKeyDataType;
}