<?php namespace gagForm;

class Checkbox extends Input {
    protected static $attributesList = [];

    public static function create($checked, array $args = []) {
        $args['type'] = 'checkbox';
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
        return in_array($value, ['checkbox']);
    }
}