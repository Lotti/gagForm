<?php namespace gagForm;

class File extends Input {
    protected static $attributesList = [];

    public static function create(array $args = []) {
        $args['type'] = 'file';
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
        return in_array($value, ['file']);
    }
}