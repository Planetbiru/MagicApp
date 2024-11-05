<?php

namespace MagicApp\AppDto\ResponseDto;

use MagicObject\MagicObject;
use ReflectionClass;
use stdClass;

/**
 * Base class that provides a `__toString` method for derived classes.
 * 
 * This class allows converting objects into a string representation (typically JSON), 
 * with customizable property naming strategies (e.g., snake_case, camelCase).
 * 
 * It is designed to be extended by other Data Transfer Object (DTO) classes 
 * to provide consistent string output across the application.
 * 
 * **Features:**
 * - Retrieves properties of the current instance, applying specified naming strategies (e.g., snake_case, camelCase).
 * - Correctly formats nested objects and arrays according to the naming conventions.
 * - Uses reflection to read class annotations for dynamic property naming strategy.
 * - Implements the `__toString` method to output a JSON representation of the object.
 * 
 * @package MagicApp\AppDto\ResponseDto
 * @author Kamshory
 * @link https://github.com/Planetbiru/MagicApp
 */
class ToString
{
    /**
     * Retrieves the properties of the current instance formatted according to the specified naming strategy.
     *
     * This method retrieves all properties of the current instance and applies the appropriate naming strategy 
     * to properties that are objects or arrays. The formatted properties are returned as an `stdClass` object.
     *
     * If no naming strategy is provided, the strategy will be determined from class annotations.
     *
     * @param string|null $namingStrategy The naming strategy to use for formatting property names.
     *                                     If null, the strategy will be determined from class annotations.
     * @return stdClass An object containing the formatted property values.
     */
    public function getPropertyValue($namingStrategy = null)
    {
        $properties = get_object_vars($this); // Get all properties of the instance
        $formattedProperties = new stdClass;

        // Determine the naming strategy from class annotations if not provided
        if ($namingStrategy === null) {
            $namingStrategy = $this->getPropertyNamingStrategy(get_class($this));
        }
        
        foreach ($properties as $key => $value) {
            // Apply the naming strategy only for object or array properties
            if ($value instanceof ToString) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value->getPropertyValue($namingStrategy);
            } elseif ($value instanceof MagicObject) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value->value($namingStrategy === 'SNAKE_CASE');
            } elseif (is_array($value)) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = [];
                foreach ($value as $k => $v) {
                    if ($v instanceof ToString) {
                        $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)}[$this->convertPropertyName($k, $namingStrategy)] = $v->getPropertyValue($namingStrategy);
                    } elseif ($v instanceof MagicObject) {
                        $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)}[$this->convertPropertyName($k, $namingStrategy)] = $v->value($namingStrategy === 'CAMEL_CASE');
                    } else {
                        $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)}[$this->convertPropertyName($k, $namingStrategy)] = $v;
                    }
                }
            } elseif (is_object($value)) {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value;
            } else {
                $formattedProperties->{$this->convertPropertyName($key, $namingStrategy)} = $value;
            }
        }
        return $formattedProperties;
    }

    /**
     * Converts the instance to a JSON string representation based on class annotations.
     *
     * This method uses the `getPropertyValue()` method to format the properties of the object 
     * and returns a JSON string. If the `prettify` annotation is set to true, 
     * the output will be prettified (formatted with indentation).
     *
     * @return string A JSON string representation of the instance.
     */
    public function __toString()
    {
        $flag = $this->getPrettify(get_class($this)) ? JSON_PRETTY_PRINT : 0;
        return json_encode($this->getPropertyValue(), $flag);
    }

    /**
     * Converts the property name to the desired format based on the specified naming convention.
     *
     * The supported naming conventions are:
     * - SNAKE_CASE
     * - KEBAB_CASE
     * - TITLE_CASE
     * - CAMEL_CASE (default)
     * - PASCAL_CASE
     * - CONSTANT_CASE
     * - FLAT_CASE
     * - DOT_NOTATION
     * - TRAIN_CASE
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
                return $name; // Fallback to original name
        }
    }

    /**
     * Extracts the value of the `property-naming-strategy` annotation from the class doc comment.
     *
     * This method uses reflection to read the class doc comment and extract the 
     * value of the `property-naming-strategy` annotation if present.
     *
     * @param string $className The name of the class to inspect.
     * @return string|null The value of the `property-naming-strategy` or null if not found.
     */
    public static function getPropertyNamingStrategy($className)
    {
        // Read the class doc comment using reflection
        $reflection = new ReflectionClass($className);
        $docComment = $reflection->getDocComment();

        // Search for the @JSON(property-naming-strategy="...") annotation
        if (preg_match('/@JSON\(property-naming-strategy="([^"]+)"\)/', $docComment, $matches)) {
            return $matches[1]; // Return the value of property-naming-strategy
        }

        return null; // Return null if not found
    }

    /**
     * Extracts the value of the `prettify` annotation from the class doc comment.
     *
     * This method uses reflection to read the class doc comment and extract the 
     * value of the `prettify` annotation if present. If the annotation is set to "true", 
     * the output will be formatted as a pretty JSON string.
     *
     * @param string $className The name of the class to inspect.
     * @return bool Returns true if prettify is enabled, false otherwise.
     */
    public static function getPrettify($className)
    {
        // Read the class doc comment using reflection
        $reflection = new ReflectionClass($className);
        $docComment = $reflection->getDocComment();
        
        // Regex pattern to extract the value of 'prettify'
        $pattern = '/prettify\s*=\s*"([^"]+)"|prettify\s*=\s*([a-zA-Z0-9_]+)/';
        if (preg_match($pattern, $docComment, $matches)) {
            return (isset($matches[1]) && strtolower($matches[1]) == 'true') || (isset($matches[2]) && strtolower($matches[2]) == 'true');
        }
        
        return false; // Return false if no match is found
    }
}
