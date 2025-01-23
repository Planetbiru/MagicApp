<?php

namespace MagicApp;

use MagicApp\AppFormOption;
use stdClass;

class AppLabelValueData extends AppFormOption
{

    /**
     * Get the HTML representation of the option as a string.
     *
     * This method generates the HTML markup for the option element. It includes
     * the value, display text, selection state, and any additional attributes.
     *
     * @return string The HTML option element
     */
    public function toJson()
    {
        $attrs = $this->getAttributes();
        $option = new stdClass;
        $values = $this->getValues();
        if (isset($this->format) && isset($this->params)) {

            $option->label = vsprintf($this->format, $values);
        } else {
            $option->label = htmlspecialchars($this->textNode);
        }

        $option->value = $this->value;
        $option->selected = $this->selected;
        $option->attrs = $attrs;
        return $option;
    }

    /**
     * Alias for the __toString() method.
     *
     * This method is an alias for `__toString()` to provide a more intuitive 
     * method name for rendering the option as a string.
     *
     * @return string The HTML option element
     */
    public function toString()
    {
        return $this->__toString();
    }
}
