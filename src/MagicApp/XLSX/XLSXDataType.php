<?php

namespace MagicApp\XLSX;

class XLSXDataType
{
    const TYPE_DOUBLE = "double";
    const TYPE_INTEGER = "integer";
    const TYPE_STRING = "string";
    
    /**
     * Column type
     *
     * @var string
     */
    private $columnType;
    
    /**
     * Type map
     *
     * @var string[]
     */
    private $map = array(
        "double" => self::TYPE_DOUBLE,
        "float" => self::TYPE_DOUBLE,
        "bigint" => self::TYPE_INTEGER,
        "smallint" => self::TYPE_INTEGER,
        "tinyint(1)" => self::TYPE_STRING,
        "tinyint" => self::TYPE_INTEGER,
        "int" => self::TYPE_INTEGER,
        "varchar" => self::TYPE_STRING,
        "char" => self::TYPE_STRING,
        "tinytext" => self::TYPE_STRING,
        "mediumtext" => self::TYPE_STRING,
        "longtext" => self::TYPE_STRING,
        "text" => self::TYPE_STRING,   
        "string" => self::TYPE_STRING,   
        "enum" => self::TYPE_STRING,   
        "bool" => self::TYPE_STRING,
        "boolean" => self::TYPE_STRING,
        "timestamp" => self::TYPE_STRING,
        "datetime" => self::TYPE_STRING,
        "date" => self::TYPE_STRING,
        "time" => self::TYPE_STRING
    );

    /**
     * Precission
     * @var integer
     */
    private $precission;
    
    /**
     * Constructor
     *
     * @param string $columnType
     */
    public function __construct($columnType, $precission = null)
    {
        $this->columnType = $columnType;
        if(isset($precission))
        {
            $this->precission = $precission;
        }
    }
    
    /**
     * Convert to Excel
     *
     * @return string
     */
    public function convertToExcel()
    {
        foreach($this->map as $key=>$value)
        {
            if(stripos($this->columnType, $key) !== false)
            {
                if(isset($this->precission) && $value == self::TYPE_DOUBLE)
                {
                    return $this->getNumberFormat($this->precission);
                }
                else
                {
                    return $value;
                }
            }
        }
        return self::TYPE_STRING;
    }

    /**
     * Get number format
     * @param mixed $precission
     * @return string
     */
    public function getNumberFormat($precission)
    {
        $prec = str_repeat('#', $precission);
        return sprintf('#,%s0', $prec);
    }
    
    /**
     * Convert to string
     *
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }
    
    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->convertToExcel();
    }
}

    