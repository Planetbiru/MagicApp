<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;
use stdClass;

/**
 * Base class providing a __toString method for derived classes.
 */
class ToString
{
    
    /**
     * Get propery value
     *
     * @return stdClass
     */
    public function getPropertyValue($namingStrategyValue = null)
    {
        $properties = get_object_vars($this); // Get all properties of the instance
        $formattedProperties = new stdClass;

        // Get the property naming strategy from the class annotations
        $namingStrategy = $this->getJsonPropertyNamingStrategy();
        if(isset($namingStrategy))
        {
            $namingStrategyValue = $namingStrategy;
        }
        
        foreach ($properties as $key => $value) {
            // Apply naming strategy only for object or array properties
            if($value instanceof ToString)
            {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)} = $value->getPropertyValue($namingStrategyValue);
            }
            else if($value instanceof MagicObject)
            {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)} = $value->value($namingStrategyValue == 'CAMEL_CASE');
            }
            else if (is_array($value)) 
            {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)} = [];
                if($this->isAssociativeArray($value))
                {
                    foreach($value as $k=>$v)
                    {
                        if($v instanceof ToString)
                        {
                            $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)}[$this->convertPropertyName($k, $namingStrategyValue)] = $v->getPropertyValue($namingStrategyValue);
                        }
                        else if($v instanceof MagicObject)
                        {
                            $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)}[$this->convertPropertyName($k, $namingStrategyValue)] = $v->value($namingStrategyValue == 'CAMEL_CASE');
                        }
                        else
                        {
                            $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)}[$this->convertPropertyName($k, $namingStrategyValue)] = $v;
                        }
                    }
                }
                else
                {
                    foreach($value as $k=>$v)
                    {
                        if($v instanceof ToString)
                        {
                            $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)}[] = $v->getPropertyValue($namingStrategyValue);
                        }
                        else if($v instanceof MagicObject)
                        {
                           
                            
                            $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)}[] = $v->value($namingStrategyValue == 'CAMEL_CASE');
                        }
                        else
                        {
                            $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)}[] = $v;
                        }
                    }
                }
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)} = $value;
            } 
            else if (is_object($value)) 
            {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)} = $value;
            } 
            else 
            {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategyValue)} = $value;
            }
        }
        return $formattedProperties;
    }
    /**
     * Convert the instance to a string representation based on JSON annotations.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->getPropertyValue(), JSON_PRETTY_PRINT);
    }

    private function isAssociativeArray($array) {
        if (array() === $array) return false; // Tidak boleh array kosong
        return array_keys($array) !== range(0, count($array) - 1);
    }

   /**
     * Convert property name to the desired format.
     *
     * @param string $name The original property name.
     * @param string $format The desired naming format.
     * @return string
     */
    private function convertPropertyName($name, $format)
    {
        switch ($format) {
            case 'SNAKE_CASE':
                return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));
            case 'KEBAB_CASE':
                return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));
            case 'TITLE_CASE':
                return ucwords(str_replace(['_', '-'], ' ', $name));
            case 'CAMEL_CASE':
                return $name; // Default to camelCase
            case 'PASCAL_CASE':
                return str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $name))); // UpperCamelCase
            case 'CONSTANT_CASE':
                return strtoupper(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name)); // ALL_UPPER_CASE
            case 'FLAT_CASE':
                return strtolower(preg_replace('/([a-z])([A-Z])/', '$1$2', $name)); // alllowercase
            case 'DOT_NOTATION':
                return strtolower(preg_replace('/([a-z])([A-Z])/', '$1.$2', $name)); // this.is.dot.notation
            case 'TRAIN_CASE':
                return strtoupper(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name)); // THIS-IS-TRAIN-CASE
            default:
                return $name; // Fallback to original
        }
    }

    /**
     * Get the JSON property naming strategy from the class annotations.
     *
     * @return string The naming strategy.
     */
    private function getJsonPropertyNamingStrategy()
    {
        $reflection = new \ReflectionClass($this);
        $docComment = $reflection->getDocComment();

        // Search for the @JSON annotation in the doc comment
        if (preg_match('/@JSON\(property-naming-strategy="([^"]+)"\)/', $docComment, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
