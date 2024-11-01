<?php

namespace MagicApp\AppDto\ResponseDto;

/**
 * Data Transfer Object (DTO) representing detailed information for a specific item.
 */
class DetailColumnDto
{
    /**
     * The field associated with the detail.
     *
     * @var string|null
     */
    protected $field;

    /**
     * The value associated with the detail.
     *
     * @var mixed|null
     */
    protected $value;

    /**
     * The type describing the detail.
     *
     * @var string|null
     */
    protected $type;

    /**
     * The label describing the detail.
     *
     * @var string|null
     */
    protected $label;

    /**
     * Hidden status.
     *
     * @var bool
     */
    protected $hidden;

    /**
     * Readonly status.
     *
     * @var bool
     */
    protected $readonly;

    /**
     * The value associated with the draft data.
     *
     * @var mixed|null
     */
    protected $valueDraft;

    /**
     * Constructor for initializing a DetailColumnDto instance.
     *
     * @param string $field The field associated with the detail.
     * @param mixed $value The value associated with the detail.
     * @param string|null $type The type describing the detail.
     * @param string|null $label The label describing the detail.
     * @param bool $readonly Whether the detail is readonly.
     * @param bool $hidden Whether the detail is hidden.
     * @param mixed|null $valueDraft The value associated with the draft data.
     */
    public function __construct($field, $value, $type = null, $label = null, $readonly = false, $hidden = false, $valueDraft = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->type = $type;
        $this->label = $label;
        $this->readonly = $readonly;
        $this->hidden = $hidden;
        $this->valueDraft = $valueDraft;
    }

    /**
     * Get the field associated with the detail.
     *
     * @return string|null The field associated with the detail.
     */ 
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field associated with the detail.
     *
     * @param string|null $field The field associated with the detail.
     * @return self The instance of this class.
     */ 
    public function setField($field): self
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Get the value associated with the detail.
     *
     * @return mixed|null The value associated with the detail.
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value associated with the detail.
     *
     * @param mixed|null $value The value associated with the detail.
     * @return self The instance of this class.
     */ 
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the type describing the detail.
     *
     * @return string|null The type describing the detail.
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type describing the detail.
     *
     * @param string|null $type The type describing the detail.
     * @return self The instance of this class.
     */ 
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the label describing the detail.
     *
     * @return string|null The label describing the detail.
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the label describing the detail.
     *
     * @param string|null $label The label describing the detail.
     * @return self The instance of this class.
     */ 
    public function setLabel($label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the hidden status.
     *
     * @return bool True if the detail is hidden, otherwise false.
     */ 
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * Set the hidden status.
     *
     * @param bool $hidden Hidden status.
     * @return self The instance of this class.
     */ 
    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * Get the readonly status.
     *
     * @return bool True if the detail is readonly, otherwise false.
     */ 
    public function getReadonly(): bool
    {
        return $this->readonly;
    }

    /**
     * Set the readonly status.
     *
     * @param bool $readonly Readonly status.
     * @return self The instance of this class.
     */ 
    public function setReadonly(bool $readonly): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * Get the value associated with the draft data.
     *
     * @return mixed|null The value associated with the draft data.
     */ 
    public function getValueDraft()
    {
        return $this->valueDraft;
    }

    /**
     * Set the value associated with the draft data.
     *
     * @param mixed|null $valueDraft The value associated with the draft data.
     * @return self The instance of this class.
     */ 
    public function setValueDraft($valueDraft): self
    {
        $this->valueDraft = $valueDraft;
        return $this;
    }
}
