<?php namespace gagForm;

/**
 * Class Radio
 *
 * Represents InputRadio element
 *
 * @package gagForm
 */
class Radio extends Input {
    protected static $attributesList = [];

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param bool $checked value of the checked attribute
     * @param array $args other attributes values
     * @return Radio
     * @see MetaElement::create
     */
    public static function create($checked, array $args = []) {
        $args['type'] = 'radio';
        $args['checked'] = $checked;
        return parent::create($args);
    }

    /**
     * Checks if passed value is an accepted type.
     *
     * @param string $value a value to be validated
     * @return bool
     */
    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['radio']);
    }
}