<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Class SelectOptionDto
 *
 * Represents an individual option within a select input element in a form. This class holds 
 * metadata related to a selection option, including the source from which the option is derived, 
 * its group (if it's part of a grouped set of options), the field it corresponds to in the data model, 
 * and the actual `OptionDto` that contains the option's display text, value, and other properties.
 * 
 * The `SelectOptionDto` is commonly used to handle structured options that come from a dynamic
 * data source, such as an API or database, allowing for proper grouping, categorization, and 
 * representation of the option in a form element.
 *
 * @package MagicApp\AppDto\ResponseDto
 */
class SelectOptionDto extends ToString
{
    /**
     * The source from which the option is derived. This could represent a data source,
     * such as an API or a database query, that provides the available options for selection.
     * 
     * Examples of source values could be "API", "Database", or a specific data path.
     *
     * @var string
     */
    public $source;

    /**
     * The group name or category to which this select option belongs. This can be used for
     * grouping options under categories based on different paths or criteria.
     * 
     * For example, `/admin`, `/user`, `/supervisor` could be groups that represent 
     * different sections or roles within the application.
     *
     * @var string
     */
    public $group;

    /**
     * The field that this option corresponds to. This could be the name of the property
     * or column in the underlying data model that the option represents.
     *
     * For instance, if the option represents a country, the field could be "country_id".
     *
     * @var string
     */
    public $field;

    /**
     * The `OptionDto` object that contains the actual option's text, value, and attributes.
     * This defines a single selection option, which typically includes properties like the 
     * option's display text and value.
     *
     * @var OptionDto
     */
    public $option;

    /**
     * Constructor for the SelectOptionDto class.
     * 
     * Initializes the `source`, `group`, `field`, and `option` properties. If no `OptionDto`
     * is provided, an empty `OptionDto` will be created to initialize the option.
     *
     * @param string $source The source from which the option is derived (e.g., API, Database).
     * @param string $group The group to which this option belongs (e.g., admin, user, supervisor).
     * @param string $field The field associated with this option (e.g., country_id, product_id).
     * @param OptionDto $option An instance of `OptionDto` that defines the option's metadata.
     */
    public function __construct($source = '', $group = '', $field = '', $option = null)
    {
        $this->source = $source;
        $this->group = $group;
        $this->field = $field;
        $this->option = isset($option) ? $option : new OptionDto(); // Default to an empty OptionDto if none provided
    }

    // Getter and Setter Methods

    /**
     * Gets the source from which the option is derived.
     *
     * @return string The source of the option (e.g., API, Database).
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets the source from which the option is derived.
     *
     * @param string $source The source to set (e.g., API, Database).
     * @return self Returns the current instance for chaining.
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Gets the group to which this option belongs.
     *
     * @return string The group name of the option (e.g., admin, user).
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Sets the group to which this option belongs.
     *
     * @param string $group The group name to set (e.g., admin, user).
     * @return self Returns the current instance for chaining.
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Gets the field that this option corresponds to.
     *
     * @return string The field name of the option (e.g., country_id, product_id).
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets the field that this option corresponds to.
     *
     * @param string $field The field name to set (e.g., country_id, product_id).
     * @return self Returns the current instance for chaining.
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Gets the `OptionDto` object that defines the option's metadata (text, value, etc.).
     *
     * @return OptionDto The option's metadata (e.g., text, value, selected state).
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Sets the `OptionDto` object that defines the option's metadata.
     *
     * @param OptionDto $option The option metadata to set.
     * @return self Returns the current instance for chaining.
     */
    public function setOption(OptionDto $option)
    {
        $this->option = $option;
        return $this;
    }
}
