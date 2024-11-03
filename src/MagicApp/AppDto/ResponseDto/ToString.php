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
     * Retrieve the properties of the current instance formatted according to the specified naming strategy.
     *
     * This method retrieves all properties of the instance and applies the appropriate naming strategy
     * to properties that are objects or arrays. The formatted properties are returned as an stdClass object.
     *
     * @param string|null $namingStrategy The naming strategy to use for formatting property names.
     *                                     If null, the strategy will be determined from class annotations.
     * @return stdClass An object containing the formatted property values.
     */
    public function getPropertyValue($namingStrategy = null)
    {
        $properties = get_object_vars($this); // Get all properties of the instance
        $formattedProperties = new stdClass;

        // Get the property naming strategy from the class annotations
        if ($namingStrategy === null) {
            $namingStrategy = $this->getJsonPropertyNamingStrategy();
        }
        
        foreach ($properties as $key => $value) {
            // Apply naming strategy only for object or array properties
            if ($value instanceof ToString) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value->getPropertyValue($namingStrategy);
            } else if ($value instanceof MagicObject) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value->value($namingStrategy == 'SNAKE_CASE');
            } else if (is_array($value)) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = [];
                foreach ($value as $k => $v) {
                    if ($v instanceof ToString) {
                        $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)}[$this->convertPropertyName($k, $namingStrategy)] = $v->getPropertyValue($namingStrategy);
                    } else if ($v instanceof MagicObject) {
                        $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)}[$this->convertPropertyName($k, $namingStrategy)] = $v->value($namingStrategy == 'CAMEL_CASE');
                    } else {
                        $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)}[$this->convertPropertyName($k, $namingStrategy)] = $v;
                    }
                }
            } else if (is_object($value)) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value;
            } else {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value;
            }
        }
        return $formattedProperties;
    }

    /**
     * Convert the instance to a string representation based on JSON annotations.
     *
     * @return string A JSON string representation of the instance.
     */
    public function __toString()
    {
        return json_encode($this->getPropertyValue(), JSON_PRETTY_PRINT);
    }

   /**
     * Convert property name to the desired format based on the specified naming convention.
     *
     * @param string $name The original property name.
     * @param string $format The desired naming format.
     * @return string The converted property name.
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
     * @return string|null The naming strategy determined from annotations, or null if not specified.
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
