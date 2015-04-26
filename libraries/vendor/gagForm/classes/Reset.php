<?php namespace gagForm;

class Reset extends Input {
    protected static $attributesList = [];

    public static function create($value, array $args = []) {
        $args['type'] = 'reset';
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
        return in_array($value, ['reset']);
    }
}