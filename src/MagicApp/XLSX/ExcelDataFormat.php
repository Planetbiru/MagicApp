<?php

namespace MagicApp\XLSX;

use Exception;
use MagicObject\MagicObject;
use MagicObject\Util\PicoStringUtil;

class ExcelDataFormat
{
    /**
     * Columns
     *
     * @var array
     */
    private $columns = array();
    
    /**
     * Constructor
     *
     * @param MagicObject $entity
     */
    public function __construct($entity)
    {
        $this->columns = array();
        try
        {
            $tableInfo = $entity->tableInfo();
            if($tableInfo != null && $tableInfo->getColumns() != null)
            {
                $columns = $tableInfo->getColumns(); 
                foreach($columns as $propertyName => $column)
                {
                    $newPropertyName = PicoStringUtil::camelize($propertyName);
                    $this->columns[$newPropertyName] = $column;
                }
            }
        }
        catch(Exception $e)
        {
            // do nothing
        }
    }
    
    /**
     * Magic method
     *
     * @param string $name
     * @param array $arguments
     * @return mixed|null|void
     */
    public function __call($name, $arguments) // NOSONAR
    {
        if(strpos($name, 0, 3) === 'get')
        {
            $newPropertyName = PicoStringUtil::camelize(substr($name, 3));
            if(isset($this->columns[$newPropertyName]))
            {
                $column = $this->columns[$newPropertyName];
                $type = isset($column['type']) ? $column['type'] : 'string';
                return $this->toExcelType($type);
            }
            return 'string';
        }
    }
    
    /**
     * Convert to Excel type
     *
     * @param string $type
     * @return ExcelDataType
     */
    public function toExcelType($type)
    {
        return new ExcelDataType($type);
    }
}