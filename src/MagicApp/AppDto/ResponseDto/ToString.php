<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Base class providing a __toString method for derived classes.
 */
class ToString
{
    /**
     * Convert the instance to a string representation based on JSON annotations.
     *
     * @return string
     */
    public function __toString()
    {
        $properties = get_object_vars($this); // Get all properties of the instance
        $formattedProperties = [];

        // Get the property naming strategy from the class annotations
        $namingStrategy = $this->getJsonPropertyNamingStrategy();

        foreach ($properties as $key => $value) {
            // Apply naming strategy only for object or array properties
            if (is_object($value) || is_array($value)) {
                $formattedProperties[$this->convertPropertyName($key, $namingStrategy)] = $value;
            } else {
                // For non-object/array properties, keep the original name
                $formattedProperties[$key] = $value;
            }
        }

        return json_encode($formattedProperties, JSON_PRETTY_PRINT);
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

        return 'CAMEL_CASE'; // Default naming strategy
    }
}
