<?php namespace gagForm;

/**
 * Class Text
 *
 * Represent InputText Element
 *
 * @package gagForm
 */
class Text extends Input {
    protected static $attributesList = [];
    protected static $tag = 'input';

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param string $value attribute value's value
     * @param array $args other attributes values
     * @return Text
     * @see MetaElement::create
     */
    public static function create($value, array $args = []) {
        $args['type'] = 'text';
        $args['value'] = $value;
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
        return in_array($value, ['text']);
    }
}