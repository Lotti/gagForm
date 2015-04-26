<?php namespace gagForm;

class Reset extends Input {
    protected static $attributesList = null;
    protected static $tag = 'input';

    public static function create($value, array $args = []) {
        $args['type'] = 'reset';
        $args['value'] = $value;
        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['reset']);
    }
}