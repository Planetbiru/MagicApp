<?php

namespace MagicApp\XLSX;

/**
 * Class XLSXDataType
 *
 * This class defines various data types that can be used in an XLSX file.
 * It maps database column types to Excel data types, handling conversions 
 * and precision for numeric values. The class provides methods for 
 * determining the appropriate Excel format based on the column type and 
 * allows for customized number formatting.
 */
class XLSXDataType
{
    const TYPE_DOUBLE    = "double";
    const TYPE_INTEGER   = "integer";
    const TYPE_STRING    = "string";
    const TYPE_DATETIME  = "datetime";
    const TYPE_DATE      = "date";
    const TYPE_TIME      = "time";
    
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
    private $map = [
        "double"        => self::TYPE_DOUBLE,
        "float"         => self::TYPE_DOUBLE,
        "bigint"        => self::TYPE_INTEGER,
        "smallint"      => self::TYPE_INTEGER,
        "tinyint(1)"    => self::TYPE_STRING,
        "tinyint"       => self::TYPE_INTEGER,
        "int"           => self::TYPE_INTEGER,
        "varchar"       => self::TYPE_STRING,
        "char"          => self::TYPE_STRING,
        "tinytext"      => self::TYPE_STRING,
        "mediumtext"    => self::TYPE_STRING,
        "longtext"      => self::TYPE_STRING,
        "text"          => self::TYPE_STRING,   
        "string"        => self::TYPE_STRING,   
        "enum"          => self::TYPE_STRING,   
        "bool"          => self::TYPE_STRING,
        "boolean"       => self::TYPE_STRING,
        "timestamp"     => self::TYPE_DATETIME,
        "datetime"      => self::TYPE_DATETIME,
        "date"          => self::TYPE_DATE,
        "time"          => self::TYPE_TIME,
    ];

    /**
     * Precision
     * @var integer
     */
    private $precision;
    
    /**
     * Constructor
     *
     * @param string $columnType Column type
     * @param integer|null $precision Precision
     */
    public function __construct($columnType, $precision = null)
    {
        $this->columnType = $columnType;
        if (isset($precision)) {
            $this->precision = $precision;
        }
    }
    
    /**
     * Convert to Excel type
     *
     * @return string
     */
    public function convertToExcel()
    {
        foreach ($this->map as $key => $value) {
            if (stripos($this->columnType, $key) !== false) {
                if (isset($this->precision) && $value == self::TYPE_DOUBLE) {
                    return $this->getNumberFormat($this->precision);
                } else {
                    return $value;
                }
            }
        }
        return self::TYPE_STRING;
    }

    /**
     * Get number format based on precision
     * 
     * @param mixed $precision Precision
     * @return string
     */
    public function getNumberFormat($precision)
    {
        $prec = str_repeat('#', $precision);
        return sprintf('#,%s0', $prec);
    }
    
    /**
     * Convert to string representation
     *
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }
    
    /**
     * Convert to string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->convertToExcel();
    }
}
