<?php

namespace MagicApp;

use MagicObject\Language\PicoEntityLanguage;
use MagicObject\MagicObject;
use MagicObject\Util\ClassUtil\PicoAnnotationParser;

/**
 * Class AppResponse
 *
 * Represents a response object for an application entity, encapsulating the entity's data, language-specific labels,
 * and associated properties.
 *
 * @package MagicApp
 */
class AppResponse
{
    /**
     * The main entity associated with the response.
     *
     * @var MagicObject
     */
    private $entity;

    /**
     * The language-specific representation of the entity.
     *
     * @var PicoEntityLanguage
     */
    private $entityLanguage;

    /**
     * The class name of the entity.
     *
     * @var string
     */
    private $className;

    /**
     * An array of properties associated with the entity.
     *
     * @var MagicObject[]
     */
    private $properties = array();

    /**
     * AppResponse constructor.
     *
     * Initializes the response with the given entity and its language representation.
     *
     * @param MagicObject $entity The entity to associate with the response.
     * @param PicoEntityLanguage $entityLanguage The language representation for the entity.
     */
    public function __construct($entity, $entityLanguage)
    {
        $this->entity = $entity;
        $this->entityLanguage = $entityLanguage;
        $this->className = get_class($entity);
    }

    /**
     * Adds a property to the response.
     *
     * This method creates a new MagicObject representing a property of the entity, populating it
     * with a label and value, and determining if it should be hidden or read-only based on the 
     * provided parameters.
     *
     * @param string $propertyName The name of the property to add.
     * @param mixed $propertyValue The value of the property.
     * @param bool $readonly Indicates if the property is read-only. Default is false.
     * @param bool $hidden Indicates if the property is hidden. Default is false.
     * @return self Returns the current instance for method chaining.
     */
    public function add($propertyName, $propertyValue, $readonly = false, $hidden = false)
    {
        $property = new MagicObject();
        
        $property->setHidden($hidden);
        $property->setReadonly($readonly);
        $property->setLabel($this->entityLanguage->get($propertyName));
        $property->setValue($propertyValue);
        
        $this->properties[] = $property;
        
        return $this;
    }

    /**
     * Gets the entity associated with the response.
     *
     * @return MagicObject Returns the entity.
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Gets the language representation of the entity.
     *
     * @return PicoEntityLanguage Returns the entity language.
     */
    public function getEntityLanguage()
    {
        return $this->entityLanguage;
    }

    /**
     * Gets the class name of the entity.
     *
     * @return string Returns the class name.
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Gets the properties associated with the entity.
     *
     * @return MagicObject[] Returns an array of properties.
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
